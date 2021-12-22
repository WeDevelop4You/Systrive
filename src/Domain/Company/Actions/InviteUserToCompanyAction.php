<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\Invite\Models\Invite;
    use Domain\User\Jobs\SendInviteToUser;
    use Domain\User\Models\User;

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
            $user = User::withTrashed()->whereEmail($companyUserData->email)->firstOrNew();

            if (!$user->exists) {
                $user->email = $companyUserData->email;
                $user->save();

                $user->delete();
            }

            (new UserPermissionsForCompanyAction($this->company, $user))($companyUserData);

            SendInviteToUser::dispatch($user, $this->company);

            $this->company->users()->attach($user->id, ['status' => Invite::COMPANY_USER_REQUESTED]);

            return $user;
        }
    }
