<?php

    namespace Domain\Company\Mappings;

    class CompanyUserTableMap
    {
        public const ID = 'id';
        public const USER_ID = 'user_id';
        public const COMPANY_ID = 'company_id';
        public const IS_OWNER = 'is_owner';
        public const STATUS = 'status';

        public const EXPIRED_STATUS = 'expired';
        public const ACCEPTED_STATUS = 'accepted';
        public const REQUESTED_STATUS = 'requested';
    }