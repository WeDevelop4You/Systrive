<?php

namespace Domain\System\Mappings;

class SystemUsageStatisticTableMap
{
    public const TABLE = 'system_usage_statistics';
    public const MORPH_MODEL = 'model';
    public const COL_MODEL_TYPE = 'model_type';
    public const COL_MODEL_ID = 'model_id';
    public const COL_TYPE = 'type';
    public const COL_TOTAL = 'total';
    public const COL_DATE = 'date';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const TABLE_MODEL_TYPE = 'system_usage_statistics.model_type';
    public const TABLE_MODEL_ID = 'system_usage_statistics.model_id';
    public const TABLE_TYPE = 'system_usage_statistics.type';
    public const TABLE_TOTAL = 'system_usage_statistics.total';
    public const TABLE_DATE = 'system_usage_statistics.date';
    public const TABLE_CREATED_AT = 'system_usage_statistics.created_at';
    public const TABLE_UPDATED_AT = 'system_usage_statistics.updated_at';
    public const RELATION_STATISTIC_FROM = 'statisticFrom';
}
