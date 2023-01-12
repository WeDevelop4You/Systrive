<?php

    namespace Domain\Authentication\Actions;

    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\CompanyUserUpdateInviteToAcceptedAction;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Enums\InviteTypes;
    use Domain\Invite\Exceptions\InvalidTokenException;
    use Domain\Invite\Models\Invite;
    use Domain\User\Actions\UpdateUserPasswordAction;
    use Domain\User\Actions\UpdateUserProfileAction;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Client\Actions\VuexAction;
    use Support\Client\Response;
    use Support\Enums\SessionKeyType;

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
            private readonly string $password,
        ) {
            $this->inviteData = new InviteData(...Response::getSessionData(SessionKeyType::REGISTRATION));

            $this->invite = (new ValidateInviteTokenAction())($this->inviteData);

            $this->user = $this->invite->user;
            $this->company = $this->invite->company;
        }

        /**
         * @param UserProfileData $userProfileData
         *
         * @return void
         */
        public function __invoke(UserProfileData $userProfileData): void
        {
            (new UpdateUserProfileAction($this->user))($userProfileData);
            (new UpdateUserPasswordAction($this->user))($this->password);

            $this->user->locale = App::getLocale();
            $this->user->email_verified_at = Carbon::now();
            $this->user->restore();

            $this->InviteTypeAction();

            Session::forget(SessionKeyType::REGISTRATION->value);

            Auth::login($this->user, true);
        }

        /**
         * @return void
         */
        private function InviteTypeAction(): void
        {
            switch ($this->invite->type) {
                case InviteTypes::USER:
                    (new CompanyUserUpdateInviteToAcceptedAction($this->user))($this->company);

                    break;
                case InviteTypes::COMPANY:
                    Response::create()
                        ->addAction(VuexAction::create()->dispatch(
                            'complete',
                            route('company.complete', [$this->company->id, $this->inviteData->token])
                        ))
                        ->toSession(SessionKeyType::KEEP);

                    break;
            }
        }
    }
