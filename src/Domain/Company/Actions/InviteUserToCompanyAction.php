<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Jobs\SendInviteEmailToUser;
    use Domain\User\Models\User;
    use Domain\User\Models\UserInvite;

    class InviteUserToCompanyAction
    {
        public function __construct(
            public Company $company,
        ) {
            //
        }

        /**
         * @param CompanyUserData $companyUserData
         *
         * @return User
         */
        public function __invoke(CompanyUserData $companyUserData): User
        {
            $user = User::whereEmail($companyUserData->email)->firstOrNew();

            if (!$user->exists) {
                $user->email = $companyUserData->email;
                $user->save();
            }

            (new UserPermissionsForCompanyAction($this->company, $user))($companyUserData);

            SendInviteEmailToUser::dispatch($user, $this->company, UserInvite::INVITE_USER_TYPE);

            $this->company->users()->attach($user->id);

            return $user;
        }
    }
