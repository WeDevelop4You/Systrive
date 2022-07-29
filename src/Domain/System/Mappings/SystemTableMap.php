<?php

    namespace Domain\System\Mappings;

    class SystemTableMap
    {
        public const TABLE = 'system';

        public const ID = 'id';
        public const COMPANY_ID = 'company_id';
        public const USERNAME = 'username';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'system.id';
        public const TABLE_COMPANY_ID = 'system.company_id';
        public const TABLE_USERNAME = 'system.username';
        public const TABLE_CREATED_AT = 'system.created_at';
        public const TABLE_UPDATED_AT = 'system.updated_at';

        public const RELATIONSHIP_COMPANY = 'company';
        public const RELATIONSHIP_DOMAINS = 'domains';
        public const RELATIONSHIP_DNS = 'dns';
        public const RELATIONSHIP_DATABASES = 'databases';
        public const RELATIONSHIP_MAIL_DOMAINS = 'mailDomains';
    }
