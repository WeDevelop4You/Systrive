<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;

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

            if (is_null($owner) || $owner->id !== $companyData->owner_id) {
                $newOwner = User::find($companyData->owner_id);

                (new ChangeCompanyOwnershipAction($newOwner, $owner, $this->removeUser))($company);
            }

            return $company;
        }
    }
