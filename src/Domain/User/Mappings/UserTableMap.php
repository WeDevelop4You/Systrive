<?php

namespace Domain\User\Mappings;

class UserTableMap
{
    public const TABLE = 'users';

    public const ID = 'id';
    public const EMAIL = 'email';
    public const LOCALE = 'locale';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const PASSWORD = 'password';
    public const REMEMBER_TOKEN = 'remember_token';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    public const TABLE_ID = 'users.id';
    public const TABLE_EMAIL = 'users.email';
    public const TABLE_LOCALE = 'users.locale';
    public const TABLE_EMAIL_VERIFIED_AT = 'users.email_verified_at';
    public const TABLE_PASSWORD = 'users.password';
    public const TABLE_REMEMBER_TOKEN = 'users.remember_token';
    public const TABLE_CREATED_AT = 'users.created_at';
    public const TABLE_UPDATED_AT = 'users.updated_at';
    public const TABLE_DELETED_AT = 'users.deleted_at';

    public const RELATIONSHIP_PROFILE = 'profile';
    public const RELATIONSHIP_SECURITY = 'security';
    public const RELATIONSHIP_GIT_ACCOUNTS = 'gitAccounts';
    public const RELATIONSHIP_COMPANIES = 'companies';
    public const RELATIONSHIP_COMPANY_USER = 'companyUser';
    public const RELATIONSHIP_ROLES = 'roles';
    public const RELATIONSHIP_PERMISSIONS = 'permissions';
}
