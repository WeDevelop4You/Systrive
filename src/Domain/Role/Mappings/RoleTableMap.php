<?php

namespace Domain\Role\Mappings;

class RoleTableMap
{
    public const TABLE = 'roles';
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_MAIN = 'Admin';
    public const COL_ID = 'id';
    public const COL_COMPANY_ID = 'company_id';
    public const COL_NAME = 'name';
    public const COL_GUARD_NAME = 'guard_name';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const TABLE_ID = 'roles.id';
    public const TABLE_COMPANY_ID = 'roles.company_id';
    public const TABLE_NAME = 'roles.name';
    public const TABLE_GUARD_NAME = 'roles.guard_name';
    public const TABLE_CREATED_AT = 'roles.created_at';
    public const TABLE_UPDATED_AT = 'roles.updated_at';
    public const RELATION_PERMISSIONS = 'permissions';
    public const RELATION_USERS = 'users';
}
