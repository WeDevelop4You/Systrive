<?php

namespace Domain\Git\Mappings;

class GitAccountAccessTokensTableMap
{
    public const TABLE = 'git_account_access_tokens';

    public const COL_ID = 'id';

    public const COL_GIT_ACCOUNT_ID = 'git_account_id';

    public const COL_TOKEN = 'token';

    public const COL_REFRESH_TOKEN = 'refresh_token';

    public const COL_EXPIRES_IN = 'expires_in';

    public const COL_CREATED_AT = 'created_at';

    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'git_account_access_tokens.id';

    public const TABLE_GIT_ACCOUNT_ID = 'git_account_access_tokens.git_account_id';

    public const TABLE_TOKEN = 'git_account_access_tokens.token';

    public const TABLE_REFRESH_TOKEN = 'git_account_access_tokens.refresh_token';

    public const TABLE_EXPIRES_IN = 'git_account_access_tokens.expires_in';

    public const TABLE_CREATED_AT = 'git_account_access_tokens.created_at';

    public const TABLE_UPDATED_AT = 'git_account_access_tokens.updated_at';
}
