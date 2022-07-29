<?php

    namespace Domain\Git\Mappings;

    class GitAccountTableMap
    {
        public const TABLE = 'git_accounts';

        public const ID = 'id';
        public const USER_ID = 'user_id';
        public const SERVICE = 'service';
        public const USERNAME = 'username';
        public const CREATED_AT = 'created_at';
        public const UPDATED_AT = 'updated_at';

        public const TABLE_ID = 'git_accounts.id';
        public const TABLE_USER_ID = 'git_accounts.user_id';
        public const TABLE_SERVICE = 'git_accounts.service';
        public const TABLE_USERNAME = 'git_accounts.username';
        public const TABLE_CREATED_AT = 'git_accounts.created_at';
        public const TABLE_UPDATED_AT = 'git_accounts.updated_at';

        public const RELATIONSHIP_ACCESS_TOKEN = 'accessToken';
    }
