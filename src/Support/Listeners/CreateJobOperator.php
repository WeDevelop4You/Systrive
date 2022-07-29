<?php

namespace Support\Listeners;

use Cache;
use Domain\Job\Models\Job;
use Domain\Job\Models\JobOperation;
use Illuminate\Queue\Events\JobQueued;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Support\Mixins\ScheduleMixin;

class CreateJobOperator
{
    /**
     * Handle the event.
     *
     * @param JobQueued $event
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     *
     * @return void
     */
    public function handle(JobQueued $event): void
    {
        $job = Job::find($event->id);

        $process = new JobOperation();
        $process->uuid = $job->uuid();
        $process->name = method_exists($event->job, 'uniqueId')
            ? $event->job->uniqueId()
            : (new ReflectionClass($job->displayName()))->getShortName();

        if (Cache::has(ScheduleMixin::CACHE_SCHEDULE_RECORD_ID)) {
            $process->parent_id = Cache::get(ScheduleMixin::CACHE_SCHEDULE_RECORD_ID);
        }

        $process->save();
    }
}
