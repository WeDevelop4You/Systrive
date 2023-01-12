<?php

namespace Domain\Git\Mappings;

class GitAccountTableMap
{
    public const TABLE = 'git_accounts';

    public const COL_ID = 'id';
    public const COL_USER_ID = 'user_id';
    public const COL_SERVICE = 'service';
    public const COL_USERNAME = 'username';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'git_accounts.id';
    public const TABLE_USER_ID = 'git_accounts.user_id';
    public const TABLE_SERVICE = 'git_accounts.service';
    public const TABLE_USERNAME = 'git_accounts.username';
    public const TABLE_CREATED_AT = 'git_accounts.created_at';
    public const TABLE_UPDATED_AT = 'git_accounts.updated_at';

    public const RELATION_ACCESS_TOKEN = 'accessToken';
}
