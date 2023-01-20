<?php

namespace Domain\User\Mappings;

class UserTableMap
{
    public const TABLE = 'users';

    public const COL_ID = 'id';

    public const COL_EMAIL = 'email';

    public const COL_LOCALE = 'locale';

    public const COL_EMAIL_VERIFIED_AT = 'email_verified_at';

    public const COL_PASSWORD = 'password';

    public const COL_REMEMBER_TOKEN = 'remember_token';

    public const COL_CREATED_AT = 'created_at';

    public const COL_UPDATED_AT = 'updated_at';

    public const COL_DELETED_AT = 'deleted_at';

    public const TABLE_ID = 'users.id';

    public const TABLE_EMAIL = 'users.email';

    public const TABLE_LOCALE = 'users.locale';

    public const TABLE_EMAIL_VERIFIED_AT = 'users.email_verified_at';

    public const TABLE_PASSWORD = 'users.password';

    public const TABLE_REMEMBER_TOKEN = 'users.remember_token';

    public const TABLE_CREATED_AT = 'users.created_at';

    public const TABLE_UPDATED_AT = 'users.updated_at';

    public const TABLE_DELETED_AT = 'users.deleted_at';

    public const RELATION_PROFILE = 'profile';

    public const RELATION_SECURITY = 'security';

    public const RELATION_GIT_ACCOUNTS = 'gitAccounts';

    public const RELATION_COMPANIES = 'companies';

    public const RELATION_COMPANY_USER = 'companyUser';

    public const RELATION_ROLES = 'roles';

    public const RELATION_PERMISSIONS = 'permissions';
}
