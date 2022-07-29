<?php

    namespace Domain\Role\Mappings;

    class RoleTableMap
    {
        public const TABLE = 'roles';

        public const ID = 'id';
        public const COMPANY_ID = 'company_id';
        public const NAME = 'name';
        public const GUARD_NAME = 'guard_name';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'roles.id';
        public const TABLE_COMPANY_ID = 'roles.company_id';
        public const TABLE_NAME = 'roles.name';
        public const TABLE_GUARD_NAME = 'roles.guard_name';
        public const TABLE_CREATED_AT = 'roles.created_at';
        public const TABLE_UPDATED_AT = 'roles.updated_at';

        public const RELATIONSHIP_PERMISSIONS = 'permissions';
        public const RELATIONSHIP_USERS = 'users';

        public const ROLE_SUPER_ADMIN = 'super_admin';
        public const ROLE_MAIN = 'Admin';
    }
