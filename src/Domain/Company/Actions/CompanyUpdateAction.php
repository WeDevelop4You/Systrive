<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;
    use Illuminate\Support\Arr;

    class CompanyUpdateAction
    {
        /**
         * UpdateCompanyAction constructor.
         *
         * @param Company $company
         * @param bool    $removeOwner
         */
        public function __construct(
            private readonly Company $company,
            private readonly bool    $removeOwner = false
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
            $company->modules = $companyData->modules->mapWithKeys(function (array $data, string $module) {
                return [$module => Arr::get($data, 'value', false)];
            });
            $company->save();

            $owner = $company->whereOwner()->first();

            if (\is_null($owner) || $owner->email !== $companyData->owner) {
                (new CompanyUpdateOwnershipAction(
                    $owner,
                    $companyData->owner,
                    $this->removeOwner
                ))($company);
            }

            return $company;
        }
    }
