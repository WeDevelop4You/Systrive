<?php

namespace Domain\Api\Mappings;

class ApiAccessTokenTableMap
{
    public const TABLE = 'api_access_tokens';
    public const COL_ID = 'id';
    public const COL_TOKENABLE_TYPE = 'tokenable_type';
    public const COL_TOKENABLE_ID = 'tokenable_id';
    public const COL_NAME = 'name';
    public const COL_TOKEN = 'token';
    public const COL_ABILITIES = 'abilities';
    public const COL_RESTRICTION = 'restriction';
    public const COL_STATEFUL = 'stateful';
    public const COL_LAST_USED_AT = 'last_used_at';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const TABLE_ID = 'api_access_tokens.id';
    public const TABLE_TOKENABLE_TYPE = 'api_access_tokens.tokenable_type';
    public const TABLE_TOKENABLE_ID = 'api_access_tokens.tokenable_id';
    public const TABLE_NAME = 'api_access_tokens.name';
    public const TABLE_TOKEN = 'api_access_tokens.token';
    public const TABLE_ABILITIES = 'api_access_tokens.abilities';
    public const TABLE_RESTRICTION = 'api_access_tokens.restriction';
    public const TABLE_STATEFUL = 'api_access_tokens.stateful';
    public const TABLE_LAST_USED_AT = 'api_access_tokens.last_used_at';
    public const TABLE_CREATED_AT = 'api_access_tokens.created_at';
    public const TABLE_UPDATED_AT = 'api_access_tokens.updated_at';
}
