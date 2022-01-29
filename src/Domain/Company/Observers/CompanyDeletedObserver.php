<?php

    namespace Domain\Company\Observers;

    use Domain\Company\Models\Company;

    class CompanyDeletedObserver
    {
        /**
         * @param Company $company
         *
         * @return void
         */
        public function deleted(Company $company): void
        {
            $company->roles()->delete();
            $company->invites()->delete();
        }
    }
