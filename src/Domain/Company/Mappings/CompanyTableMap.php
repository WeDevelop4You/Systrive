<?php

    namespace Domain\Company\Mappings;

    class CompanyTableMap
    {
        public const TABLE = 'companies';

        public const ID = 'id';
        public const NAME = 'name';
        public const SLUG = 'slug';
        public const EMAIL = 'email';
        public const DOMAIN = 'domain';
        public const INFORMATION = 'information';
        public const STATUS = 'status';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'companies.id';
        public const TABLE_NAME = 'companies.name';
        public const TABLE_SLUG = 'companies.slug';
        public const TABLE_EMAIL = 'companies.email';
        public const TABLE_DOMAIN = 'companies.domain';
        public const TABLE_INFORMATION = 'companies.information';
        public const TABLE_STATUS = 'companies.status';
        public const TABLE_CREATED_AT = 'companies.created_at';
        public const TABLE_UPDATED_AT = 'companies.updated_at';

        public const RELATIONSHIP_USERS = 'users';
        public const RELATIONSHIP_ROLES = 'roles';
        public const RELATIONSHIP_INVITES = 'invites';
        public const RELATIONSHIP_COMPANY_USER = 'companyUser';
        public const RELATIONSHIP_SYSTEM = 'system';
    }
