<?php

namespace Domain\Company\Observers;

use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\CompanyUser;
use Domain\Role\Mappings\RoleTableMap;
use Domain\User\Models\User;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class CompanyUserUpdatedObserver
{
    /**
     * @param CompanyUser $companyUser
     *
     * @return bool
     */
    public function updated(CompanyUser $companyUser): bool
    {
        if ($companyUser->wasChanged(CompanyUserTableMap::COL_IS_OWNER)) {
            setCompanyId($companyUser->company_id);

            $user = $companyUser->user ?: User::withTrashed()->find($companyUser->user_id);

            try {
                if ($companyUser->is_owner) {
                    $user->syncPermissions([]);
                    $user->syncRoles(RoleTableMap::ROLE_MAIN);
                } else {
                    $user->removeRole(RoleTableMap::ROLE_MAIN);
                }
            } catch (RoleDoesNotExist) {
                return false;
            }
        }

        return true;
    }
}
