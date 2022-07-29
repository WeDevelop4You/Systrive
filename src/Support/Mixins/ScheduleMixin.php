<?php

namespace Support\Mixins;

use Closure;
use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Models\JobOperation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;

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
        return function (\Support\Enums\ScheduleTypes $type, string $job) {
            return $this->job(new $job())
                ->cleanUp()
                ->before(function () use ($type) {
                    $scheduleJob = new JobOperation();
                    $scheduleJob->schedule_type = $type;
                    $scheduleJob->status = JobOperationStatusTypes::PROCESSING;
                    $scheduleJob->save();

                    Cache::forever(ScheduleMixin::CACHE_SCHEDULE_RECORD_ID, $scheduleJob->id);
                })
                ->name($type->getName());
        };
    }
}
