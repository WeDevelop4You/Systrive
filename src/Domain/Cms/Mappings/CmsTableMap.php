<?php

namespace Domain\Cms\Mappings;

class CmsTableMap
{
    public const TABLE = 'cms';

    public const ID = 'id';
    public const COMPANY_ID = 'company_id';
    public const NAME = 'name';
    public const DATABASE = 'database';
    public const USERNAME = 'username';
    public const PASSWORD = 'password';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';

    public const TABLE_ID = 'cms.id';
    public const TABLE_COMPANY_ID = 'cms.company_id';
    public const TABLE_NAME = 'cms.name';
    public const TABLE_DATABASE = 'cms.database';
    public const TABLE_USERNAME = 'cms.username';
    public const TABLE_PASSWORD = 'cms.password';
    public const TABLE_CREATED_AT = 'cms.created_at';
    public const TABLE_UPDATED_AT = 'cms.updated_at';
    public const TABLE_DELETED_AT = 'cms.deleted_at';

    public const RELATIONSHIP_COMPANY = 'company';
}
