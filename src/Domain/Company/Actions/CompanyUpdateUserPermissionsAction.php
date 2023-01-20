<?php

namespace Domain\Company\Actions;

use Domain\Company\DataTransferObjects\CompanyUserData;
use Domain\Company\Models\Company;
use Domain\User\Models\User;

class CompanyUpdateUserPermissionsAction
{
    /**
     * UserPermissionsForCompanyAction constructor.
     *
     * @param Company $company
     */
    public function __construct(
            private readonly Company $company,
        ) {
            //
    }

    /**
     * @param CompanyUserData $companyUserData
     *
     * @return User
     */
    public function __invoke(CompanyUserData $companyUserData): User
    {
        setPermissionsTeamId($this->company->id);

        $user = $companyUserData->user;
        $user->syncRoles($companyUserData->roles);
        $user->syncPermissions($companyUserData->permissions);

        return $user;
    }
}
