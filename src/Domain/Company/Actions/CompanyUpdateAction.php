<?php

namespace Domain\Company\Actions;

use Domain\Company\DataTransferObjects\CompanyUpdateData;
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
            private readonly bool $removeOwner = false
        ) {
            //
    }

    /**
     * @param CompanyUpdateData $companyData
     *
     * @return Company
     */
    public function __invoke(CompanyUpdateData $companyData): Company
    {
        $company = $this->company;
        $owner = $this->company->owner;

        $company->name = $companyData->name;
        $company->email = $companyData->email;
        $company->domain = $companyData->domain;
        $company->modules = $companyData->modules->mapWithKeys(function (array $data, string $module) {
            return [$module => Arr::get($data, 'value', false)];
        });
        $this->company->save();

        if (\is_null($owner) || $owner->is($companyData->owner)) {
            (new CompanyUpdateOwnershipAction($owner, $companyData->owner, $this->removeOwner))($company);
        }

        return $company;
    }
}
