<?php

namespace Domain\User\Mappings;

class UserSecurityTableMap
{
    public const TABLE = 'user_security';

    public const USER_ID = 'user_id';
    public const SECRET_KEY = 'secret_key';
    public const RECOVERY_CODES = 'recovery_codes';
    public const ENABLED = 'enabled';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE_USER_ID = 'user_security.user_id';
    public const TABLE_SECRET_KEY = 'user_security.secret_key';
    public const TABLE_RECOVERY_CODES = 'user_security.recovery_codes';
    public const TABLE_ENABLED = 'user_security.enabled';
    public const TABLE_CREATED_AT = 'user_security.created_at';
    public const TABLE_UPDATED_AT = 'user_security.updated_at';
}
