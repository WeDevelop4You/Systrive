<?php

    namespace Domain\User\Actions;

    use Domain\Company\Actions\UserInviteToCompanyAcceptedAction;
    use Domain\Company\Models\Company;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
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
         * RegisterUserAction constructor.
         *
         * @param string $password
         *
         * @throws InvalidTokenException
         */
        public function __construct(
            private string $password,
        ) {
            $userInvite = (new ValidateInviteTokenAction(...Session::get(Response::SESSION_KEY_REGISTRATION)))();

            $this->company = Company::findOrFail($userInvite->company_id);
            $this->user = User::withTrashed()->whereEmail($userInvite->email)->firstOrFail();
        }

        /**
         * @param UserProfileData $userProfileData
         *
         * @return void
         */
        public function __invoke(UserProfileData $userProfileData): void
        {
            (new EditPasswordAction($this->user))($this->password);

            $userProfile = new UserProfile();
            $userProfile->first_name = $userProfileData->first_name;
            $userProfile->middle_name = $userProfileData->middle_name;
            $userProfile->last_name = $userProfileData->last_name;
            $userProfile->gender = $userProfileData->gender;
            $userProfile->birth_date = $userProfileData->birth_date;

            $this->user->profile()->save($userProfile);

            $this->user->email_verified_at = Carbon::now();
            $this->user->restore();

            (new UserInviteToCompanyAcceptedAction($this->user))($this->company);

            Session::forget(Response::SESSION_KEY_REGISTRATION);

            Auth::login($this->user, true);
        }
    }
