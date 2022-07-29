<?php

    namespace Domain\System\Mappings;

    class SystemDomainTableMap
    {
        public const TABLE = 'system_domains';

        public const ID = 'id';
        public const SYSTEM_ID = 'system_id';
        public const NAME = 'name';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'system_domains.id';
        public const TABLE_SYSTEM_ID = 'system_domains.system_id';
        public const TABLE_NAME = 'system_domains.name';
        public const TABLE_CREATED_AT = 'system_domains.created_at';
        public const TABLE_UPDATED_AT = 'system_domains.updated_at';

        public const RELATIONSHIP_USAGE_STATISTICS = 'usageStatistics';
    }
