<?php

namespace Domain\User\Mappings;

class UserSecurityTableMap
{
    public const TABLE = 'user_security';

    public const COL_USER_ID = 'user_id';

    public const COL_SECRET_KEY = 'secret_key';

    public const COL_RECOVERY_CODES = 'recovery_codes';

    public const COL_ENABLED = 'enabled';

    public const COL_CREATED_AT = 'created_at';

    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_USER_ID = 'user_security.user_id';

    public const TABLE_SECRET_KEY = 'user_security.secret_key';

    public const TABLE_RECOVERY_CODES = 'user_security.recovery_codes';

    public const TABLE_ENABLED = 'user_security.enabled';

    public const TABLE_CREATED_AT = 'user_security.created_at';

    public const TABLE_UPDATED_AT = 'user_security.updated_at';
}
