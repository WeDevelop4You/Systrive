<?php

namespace Support\Mixins;

use Closure;
use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Models\JobOperation;
use Illuminate\Console\Scheduling\Schedule;

/**
 * @mixin Schedule
 */
class ScheduleMixin
{
    public const CACHE_SCHEDULE_RECORD_ID = 'schedule_record_id';

    /**
     * @return Closure
     */
    public function recordJob(): Closure
    {
        return function (\Support\Enums\ScheduleType $type, string $job, array $arguments = []) {
            $scheduleJob = new JobOperation();
            $scheduleJob->schedule_type = $type;
            $scheduleJob->status = JobOperationStatusTypes::PROCESSING;
            $scheduleJob->save();

            return $this->job(new $job($scheduleJob->id, ...$arguments))
                ->name($type->getName());
        };
    }
}
