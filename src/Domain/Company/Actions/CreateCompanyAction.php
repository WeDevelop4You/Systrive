<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;

    class CreateCompanyAction
    {
        /**
         * @param CompanyData $companyData
         *
         * @return Company
         */
        public function __invoke(CompanyData $companyData): Company
        {
            $company = new Company();
            $company->name = $companyData->name;
            $company->email = $companyData->email;
            $company->domain = $companyData->domain;
            $company->owner_id = $companyData->owner_id;
            $company->save();

            $company->users()->attach($companyData->owner_id);

            return $company;
        }
    }
