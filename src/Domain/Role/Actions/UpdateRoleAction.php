<?php

    namespace Domain\Role\Actions;

    use Domain\Role\DataTransferObjects\RoleData;
    use Spatie\Permission\Models\Role;

    class UpdateRoleAction
    {
        /**
         * EditRoleAction constructor.
         *
         * @param Role $role
         */
        public function __construct(
            private Role $role
        ) {
        }

        /**
         * @param RoleData $roleData
         *
         * @return Role
         */
        public function __invoke(RoleData $roleData): Role
        {
            $role = $this->role;

            $role->name = $roleData->name;
            $role->syncPermissions(...$roleData->permissions);

            if ($role->isDirty()) {
                $role->save();
            }

            return $role;
        }
    }
