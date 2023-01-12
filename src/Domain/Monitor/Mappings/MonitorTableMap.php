<?php

namespace Domain\Monitor\Mappings;

class MonitorTableMap
{
    public const TABLE = 'monitors';

    public const DURATION_TIME_GOOD = 1000;
    public const DURATION_TIME_MEDIUM = 3000;

    public const COL_ID = 'id';
    public const COL_UUID = 'uuid';
    public const COL_NAME = 'name';
    public const COL_STATUS = 'status';
    public const COL_STARTED = 'started';
    public const COL_ENDED = 'ended';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'monitors.id';
    public const TABLE_UUID = 'monitors.uuid';
    public const TABLE_NAME = 'monitors.name';
    public const TABLE_STATUS = 'monitors.status';
    public const TABLE_STARTED = 'monitors.started';
    public const TABLE_ENDED = 'monitors.ended';
    public const TABLE_CREATED_AT = 'monitors.created_at';
    public const TABLE_UPDATED_AT = 'monitors.updated_at';
}
