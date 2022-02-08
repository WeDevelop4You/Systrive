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
            $company->save();

            $owner = $company->whereOwner()->first();

            if (is_null($owner) || $owner->email !== $companyData->owner_email) {
                (new ChangeCompanyOwnershipAction(
                    $owner,
                    $companyData->owner_email,
                    $this->removeUser
                ))($company);
            }

            return $company;
        }
    }
