<?php

namespace Domain\Job\Mappings;

class JobOperationTableMap
{
	public const TABLE = 'job_operations';

	public const ID = 'id';
	public const SCHEDULE_TYPE = 'schedule_type';
	public const PARENT_ID = 'parent_id';
	public const UUID = 'uuid';
	public const NAME = 'name';
	public const START_TIME = 'start_time';
	public const END_TIME = 'end_time';
	public const STATUS = 'status';
	public const CREATED_AT = 'created_at';
	public const UPDATED_AT = 'updated_at';

	public const TABLE_ID = 'job_operations.id';
	public const TABLE_SCHEDULE_TYPE = 'job_operations.schedule_type';
	public const TABLE_PARENT_ID = 'job_operations.parent_id';
	public const TABLE_UUID = 'job_operations.uuid';
	public const TABLE_NAME = 'job_operations.name';
	public const TABLE_START_TIME = 'job_operations.start_time';
	public const TABLE_END_TIME = 'job_operations.end_time';
	public const TABLE_STATUS = 'job_operations.status';
	public const TABLE_CREATED_AT = 'job_operations.created_at';
	public const TABLE_UPDATED_AT = 'job_operations.updated_at';

	public const RELATIONSHIP_CHILDREN = 'children';
	public const RELATIONSHIP_PARENT = 'parent';

	public const DURATION_TIME_GOOD = 800;
	public const DURATION_TIME_MEDIUM = 2000;
}
