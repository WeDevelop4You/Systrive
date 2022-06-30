<?php

    namespace Domain\System\Mappings;

    class SystemDatabaseTableMap
    {
        public const TABLE = 'system_databases';

        public const ID = 'id';
        public const SYSTEM_ID = 'system_id';
        public const NAME = 'name';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'system_databases.id';
        public const TABLE_SYSTEM_ID = 'system_databases.system_id';
        public const TABLE_NAME = 'system_databases.name';
        public const TABLE_CREATED_AT = 'system_databases.created_at';
        public const TABLE_UPDATED_AT = 'system_databases.updated_at';

        public const RELATIONSHIP_USAGE_STATISTICS = 'usageStatistics';
    }
