<?php

namespace Domain\Invite\Mappings;

class InviteTableMap
{
    public const TABLE = 'invites';

    public const COMPANY_ID = 'company_id';
    public const USER_ID = 'user_id';
    public const TOKEN = 'token';
    public const TYPE = 'type';
    public const CREATED_AT = 'created_at';

    public const TABLE_COMPANY_ID = 'invites.company_id';
    public const TABLE_USER_ID = 'invites.user_id';
    public const TABLE_TOKEN = 'invites.token';
    public const TABLE_TYPE = 'invites.type';
    public const TABLE_CREATED_AT = 'invites.created_at';

    public const RELATIONSHIP_COMPANY = 'company';
    public const RELATIONSHIP_USER = 'user';
}
