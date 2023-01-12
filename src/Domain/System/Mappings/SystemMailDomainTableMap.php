<?php

namespace Domain\System\Mappings;

class SystemMailDomainTableMap
{
    public const TABLE = 'system_mail_domains';

    public const COL_ID = 'id';
    public const COL_SYSTEM_ID = 'system_id';
    public const COL_NAME = 'name';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'system_mail_domains.id';
    public const TABLE_SYSTEM_ID = 'system_mail_domains.system_id';
    public const TABLE_NAME = 'system_mail_domains.name';
    public const TABLE_CREATED_AT = 'system_mail_domains.created_at';
    public const TABLE_UPDATED_AT = 'system_mail_domains.updated_at';

    public const RELATION_USAGE_STATISTICS = 'usageStatistics';
}
