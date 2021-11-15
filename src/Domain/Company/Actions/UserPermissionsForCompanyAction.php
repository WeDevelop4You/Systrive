<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;

    class UserPermissionsForCompanyAction
    {
        /**
         * UserPermissionsForCompanyAction constructor.
         *
         * @param Company $company
         * @param User    $user
         */
        public function __construct(
            public Company $company,
            public User $user,
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
            setPermissionsTeamId($this->company->id);

            $user = $this->user;
            $user->syncRoles($companyUserData->roles);
            $user->syncPermissions($companyUserData->permissions);

            return $user;
        }
    }
