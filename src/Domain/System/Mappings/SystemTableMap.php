<?php

namespace Domain\System\Mappings;

class SystemTableMap
{
    public const TABLE = 'system';

    public const COL_ID = 'id';

    public const COL_COMPANY_ID = 'company_id';

    public const COL_USERNAME = 'username';

    public const COL_CREATED_AT = 'created_at';

    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'system.id';

    public const TABLE_COMPANY_ID = 'system.company_id';

    public const TABLE_USERNAME = 'system.username';

    public const TABLE_CREATED_AT = 'system.created_at';

    public const TABLE_UPDATED_AT = 'system.updated_at';

    public const RELATION_COMPANY = 'company';

    public const RELATION_DOMAINS = 'domains';

    public const RELATION_DNS = 'dns';

    public const RELATION_DATABASES = 'databases';

    public const RELATION_MAIL_DOMAINS = 'mailDomains';
}
