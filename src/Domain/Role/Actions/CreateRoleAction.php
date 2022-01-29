<?php

    namespace Domain\Role\Actions;

    use Domain\Company\Models\Company;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Models\Role;

    class CreateRoleAction
    {
        public function __construct(
            private Company $company
        ) {
            //
        }

        /**
         * @param RoleData $roleData
         *
         * @return Role
         */
        public function __invoke(RoleData $roleData): Role
        {
            $role = new Role();
            $role->name = $roleData->name;
            $role->company_id = $this->company->id;
            $role->guard_name = 'sanctum';
            $role->save();

            $role->givePermissionTo(...$roleData->permissions);

            return $role;
        }
    }
