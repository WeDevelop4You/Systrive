<?php

namespace Domain\Job\Mappings;

class JobTableMap
{
	public const TABLE = 'jobs';

	public const ID = 'id';
	public const QUEUE = 'queue';
	public const PAYLOAD = 'payload';
	public const ATTEMPTS = 'attempts';
	public const RESERVED_AT = 'reserved_at';
	public const AVAILABLE_AT = 'available_at';
	public const CREATED_AT = 'created_at';

	public const TABLE_ID = 'jobs.id';
	public const TABLE_QUEUE = 'jobs.queue';
	public const TABLE_PAYLOAD = 'jobs.payload';
	public const TABLE_ATTEMPTS = 'jobs.attempts';
	public const TABLE_RESERVED_AT = 'jobs.reserved_at';
	public const TABLE_AVAILABLE_AT = 'jobs.available_at';
	public const TABLE_CREATED_AT = 'jobs.created_at';
}
