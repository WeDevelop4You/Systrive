<?php

namespace Domain\System\Mappings;

class SystemDatabaseTableMap
{
    public const TABLE = 'system_databases';
    public const COL_ID = 'id';
    public const COL_SYSTEM_ID = 'system_id';
    public const COL_NAME = 'name';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const TABLE_ID = 'system_databases.id';
    public const TABLE_SYSTEM_ID = 'system_databases.system_id';
    public const TABLE_NAME = 'system_databases.name';
    public const TABLE_CREATED_AT = 'system_databases.created_at';
    public const TABLE_UPDATED_AT = 'system_databases.updated_at';
    public const RELATION_USAGE_STATISTICS = 'usageStatistics';
}
