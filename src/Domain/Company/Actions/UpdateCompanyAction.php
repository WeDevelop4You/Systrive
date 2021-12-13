<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;

    class UpdateCompanyAction
    {
        public function __construct(
            private Company $company,
            private bool $removeUser = false
        ) {
            //
        }

        /**
         * @param CompanyData $companyData
         *
         * @return Company
         */
        public function __invoke(CompanyData $companyData): Company
        {
            $company = $this->company;

            $company->name = $companyData->name;
            $company->email = $companyData->email;
            $company->domain = $companyData->domain;
            $company->owner_id = $companyData->owner_id;

            if ($company->isDirty('owner_id')) {
                $company->users()->syncWithoutDetaching([$companyData->owner_id]);

                if ($this->removeUser) {
                    $company->users()->detach($company->getRawOriginal('owner_id'));
                }
            }

            $company->save();

            return $company;
        }
    }
