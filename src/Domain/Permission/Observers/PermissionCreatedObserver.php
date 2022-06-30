<?php

    namespace Domain\Permission\Observers;

    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Spatie\Permission\Models\Permission;

    class PermissionCreatedObserver
    {
        /**
         * @param Permission $permission
         *
         * @return void
         */
        public function created(Permission $permission): void
        {
            Role::where('name', RoleTableMap::ROLE_MAIN)->get()->each(function (Role $role) use ($permission) {
                $role->givePermissionTo($permission);
            });
        }
    }
