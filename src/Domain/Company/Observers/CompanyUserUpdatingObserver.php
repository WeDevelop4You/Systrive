<?php

    namespace Domain\Company\Observers;

    use Domain\Company\Models\CompanyUser;
    use Domain\Role\Mappings\RoleTableMap;
    use Spatie\Permission\Exceptions\RoleDoesNotExist;

    class CompanyUserUpdatingObserver
    {
        /**
         * @param CompanyUser $companyUser
         *
         * @return bool
         */
        public function updating(CompanyUser $companyUser): bool
        {
            $user = $companyUser->user;
            setCompanyId($companyUser->company_id);

            try {
                if ($companyUser->is_owner) {
                    $user->syncPermissions([]);
                    $user->syncRoles(RoleTableMap::MAIN_ROLE);
                } else {
                    $user->removeRole(RoleTableMap::MAIN_ROLE);
                }
            } catch (RoleDoesNotExist) {
                return false;
            }

            return true;
        }
    }
