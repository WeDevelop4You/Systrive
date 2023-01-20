<?php

namespace Domain\Permission\Mappings;

class PermissionTableMap
{
    public const TABLE = 'permissions';

    public const COL_ID = 'id';

    public const COL_NAME = 'name';

    public const COL_GUARD_NAME = 'guard_name';

    public const COL_CREATED_AT = 'created_at';

    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'permissions.id';

    public const TABLE_NAME = 'permissions.name';

    public const TABLE_GUARD_NAME = 'permissions.guard_name';

    public const TABLE_CREATED_AT = 'permissions.created_at';

    public const TABLE_UPDATED_AT = 'permissions.updated_at';

    public const RELATION_ROLES = 'roles';

    public const RELATION_USERS = 'users';

    public const RELATION_PERMISSIONS = 'permissions';
}
