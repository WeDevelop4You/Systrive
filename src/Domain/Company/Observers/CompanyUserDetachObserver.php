<?php

    namespace Domain\Company\Observers;

    use Domain\Company\Models\CompanyUser;

    class CompanyUserDetachObserver
    {
        /**
         * @param CompanyUser $companyUser
         *
         * @return void
         */
        public function deleted(CompanyUser $companyUser): void
        {
            setCompanyId($companyUser->company_id);

            $user = $companyUser->user;

            $user->syncRoles([]);
            $user->syncPermissions([]);
        }
    }
