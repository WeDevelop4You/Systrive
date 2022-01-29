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
            $user = $companyUser->user;

            $user->syncRoles([]);
            $user->syncPermissions([]);
        }
    }
