<?php

namespace Domain\Monitor\Mappings;

class JobTableMap
{
    public const TABLE = 'jobs';

    public const COL_ID = 'id';

    public const COL_QUEUE = 'queue';

    public const COL_PAYLOAD = 'payload';

    public const COL_ATTEMPTS = 'attempts';

    public const COL_RESERVED_AT = 'reserved_at';

    public const COL_AVAILABLE_AT = 'available_at';

    public const COL_CREATED_AT = 'created_at';

    public const TABLE_ID = 'jobs.id';

    public const TABLE_QUEUE = 'jobs.queue';

    public const TABLE_PAYLOAD = 'jobs.payload';

    public const TABLE_ATTEMPTS = 'jobs.attempts';

    public const TABLE_RESERVED_AT = 'jobs.reserved_at';

    public const TABLE_AVAILABLE_AT = 'jobs.available_at';

    public const TABLE_CREATED_AT = 'jobs.created_at';
}
