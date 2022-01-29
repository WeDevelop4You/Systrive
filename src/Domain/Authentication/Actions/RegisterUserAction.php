<?php

    namespace Domain\Authentication\Actions;

    use Domain\Company\Actions\User\UserInviteToCompanyAcceptedAction;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Actions\UpdatePasswordAction;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use function route;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Action\Methods\RequestMethod;
    use Support\Helpers\Response\Response;

    class RegisterUserAction
    {
        /**
         * @var User
         */
        private User $user;

        /**
         * @var Company
         */
        private Company $company;

        /**
         * @var Invite
         */
        private Invite $invite;

        /**
         * @var InviteData
         */
        private InviteData $inviteData;

        /**
         * RegisterUserAction constructor.
         *
         * @param string $password
         *
         * @throws InvalidTokenException
         * @throws ModelNotFoundException
         */
        public function __construct(
            private string $password,
        ) {
            $this->inviteData = new InviteData(...Response::getSessionData(Response::SESSION_KEY_REGISTRATION));

            $this->invite = (new ValidateInviteTokenAction())($this->inviteData);

            $this->company = Company::findOrFail($this->invite->company_id);
            $this->user = User::withTrashed()->whereEmail($this->invite->email)->firstOrFail();
        }

        /**
         * @param UserProfileData $userProfileData
         *
         * @throws InvalidTokenException
         *
         * @return void
         */
        public function __invoke(UserProfileData $userProfileData): void
        {
            (new UpdatePasswordAction($this->user))($this->password);

            $userProfile = $this->user->profile()->firstOrNew();
            $userProfile->first_name = $userProfileData->first_name;
            $userProfile->middle_name = $userProfileData->middle_name;
            $userProfile->last_name = $userProfileData->last_name;
            $userProfile->gender = $userProfileData->gender;
            $userProfile->birth_date = $userProfileData->birth_date;
            $userProfile->save();

            $this->user->email_verified_at = Carbon::now();
            $this->user->restore();

            $this->InviteTypeAction();

            Session::forget(Response::SESSION_KEY_REGISTRATION);

            Auth::login($this->user, true);
        }

        /**
         * @throws InvalidTokenException
         *
         * @return void
         */
        private function InviteTypeAction(): void
        {
            switch ($this->invite->type) {
                case InviteTableMap::USER_TYPE:
                    (new UserInviteToCompanyAcceptedAction($this->user))($this->company);

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    Response::create()
                        ->addAction(
                            RequestMethod::create()
                            ->get(route('admin.company.complete', [$this->invite->company_id, $this->inviteData->token]))
                        )
                        ->toSession(Response::SESSION_KEY_MODAL);

                    break;
                default:
                    throw new InvalidTokenException();
            }
        }
    }
