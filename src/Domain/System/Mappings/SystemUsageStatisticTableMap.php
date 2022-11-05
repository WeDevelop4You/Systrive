<?php

namespace Domain\System\Mappings;

class SystemUsageStatisticTableMap
{
    public const TABLE = 'system_usage_statistics';

    public const MODEL_TYPE = 'model_type';
    public const MODEL_ID = 'model_id';
    public const TYPE = 'type';
    public const TOTAL = 'total';
    public const DATE = 'date';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE_MODEL_TYPE = 'system_usage_statistics.model_type';
    public const TABLE_MODEL_ID = 'system_usage_statistics.model_id';
    public const TABLE_TYPE = 'system_usage_statistics.type';
    public const TABLE_TOTAL = 'system_usage_statistics.total';
    public const TABLE_DATE = 'system_usage_statistics.date';
    public const TABLE_CREATED_AT = 'system_usage_statistics.created_at';
    public const TABLE_UPDATED_AT = 'system_usage_statistics.updated_at';

    public const RELATIONSHIP_STATISTIC_FROM = 'statisticFrom';

    public const MORPH_MODEL = 'model';
}
