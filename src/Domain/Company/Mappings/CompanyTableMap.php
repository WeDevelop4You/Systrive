<?php

    namespace Domain\Company\Mappings;

    class CompanyTableMap
    {
        public const ID = 'id';
        public const NAME = 'name';
        public const EMAIL = 'email';
        public const DOMAIN = 'domain';
        public const INFORMATION = 'information';
        public const STATUS = 'status';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const INVITED_STATUS = 'invited';
        public const EXPIRED_STATUS = 'expired';
        public const COMPLETED_STATUS = 'completed';
    }
