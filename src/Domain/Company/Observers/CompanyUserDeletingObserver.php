<?php

    namespace Domain\Company\Observers;

    use Domain\Company\Models\CompanyUser;

    class CompanyUserDeletingObserver
    {
        /**
         * @param CompanyUser $companyUser
         *
         * @return void
         */
        public function deleting(CompanyUser $companyUser): void
        {
            setCompanyId($companyUser->company_id);

            $user = $companyUser->user;

            $user->syncRoles([]);
            $user->syncPermissions([]);
        }
    }
