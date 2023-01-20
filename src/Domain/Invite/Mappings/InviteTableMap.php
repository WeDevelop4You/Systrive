<?php

namespace Domain\Invite\Mappings;

class InviteTableMap
{
    public const TABLE = 'invites';

    public const COL_COMPANY_ID = 'company_id';

    public const COL_USER_ID = 'user_id';

    public const COL_TOKEN = 'token';

    public const COL_TYPE = 'type';

    public const COL_CREATED_AT = 'created_at';

    public const TABLE_COMPANY_ID = 'invites.company_id';

    public const TABLE_USER_ID = 'invites.user_id';

    public const TABLE_TOKEN = 'invites.token';

    public const TABLE_TYPE = 'invites.type';

    public const TABLE_CREATED_AT = 'invites.created_at';

    public const RELATION_COMPANY = 'company';

    public const RELATION_USER = 'user';
}
