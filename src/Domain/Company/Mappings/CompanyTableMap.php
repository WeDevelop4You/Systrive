<?php

namespace Domain\Company\Mappings;

class CompanyTableMap
{
    public const TABLE = 'companies';
    public const COL_ID = 'id';
    public const COL_NAME = 'name';
    public const COL_SLUG = 'slug';
    public const COL_EMAIL = 'email';
    public const COL_DOMAIN = 'domain';
    public const COL_STATUS = 'status';
    public const COL_MODULES = 'modules';
    public const COL_PREFERENCES = 'preferences';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const COL_DELETED_AT = 'deleted_at';
    public const TABLE_ID = 'companies.id';
    public const TABLE_NAME = 'companies.name';
    public const TABLE_SLUG = 'companies.slug';
    public const TABLE_EMAIL = 'companies.email';
    public const TABLE_DOMAIN = 'companies.domain';
    public const TABLE_STATUS = 'companies.status';
    public const TABLE_MODULES = 'companies.modules';
    public const TABLE_PREFERENCES = 'companies.preferences';
    public const TABLE_CREATED_AT = 'companies.created_at';
    public const TABLE_UPDATED_AT = 'companies.updated_at';
    public const TABLE_DELETED_AT = 'companies.deleted_at';
    public const RELATION_USER = 'user';
    public const RELATION_OWNER = 'owner';
    public const RELATION_USERS = 'users';
    public const RELATION_ROLES = 'roles';
    public const RELATION_INVITES = 'invites';
    public const RELATION_COMPANY_USER = 'companyUser';
    public const RELATION_SYSTEM = 'system';
    public const RELATION_SYSTEMS = 'systems';
    public const RELATION_CMS = 'cms';
}
