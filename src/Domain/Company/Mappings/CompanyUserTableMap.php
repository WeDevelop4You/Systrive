<?php

    namespace Domain\Company\Mappings;

    class CompanyUserTableMap
    {
        public const TABLE = 'company_user';

        public const ID = 'id';
        public const USER_ID = 'user_id';
        public const COMPANY_ID = 'company_id';
        public const IS_OWNER = 'is_owner';
        public const STATUS = 'status';

        public const TABLE_ID = 'company_user.id';
        public const TABLE_USER_ID = 'company_user.user_id';
        public const TABLE_COMPANY_ID = 'company_user.company_id';
        public const TABLE_IS_OWNER = 'company_user.is_owner';
        public const TABLE_STATUS = 'company_user.status';

        public const RELATIONSHIP_USER = 'user';
    }
