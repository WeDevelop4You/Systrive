<?php

namespace Domain\Monitor\Listeners;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Interfaces\ShouldBeNamed;
use Domain\Monitor\Interfaces\WithMonitoring;
use Domain\Monitor\Models\Job;
use Domain\Monitor\Models\Monitor;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\Events\JobQueued;
use ReflectionClass;
use ReflectionException;

class MonitorCreate
{
    /**
     * Handle the event.
     *
     * @param JobQueued $event
     *
     * @throws ReflectionException
     *
     * @return void
     */
    public function handle(JobQueued $event): void
    {
        $job = $event->job;

        if ($job instanceof WithMonitoring) {
            $name = match (true) {
                $job instanceof ShouldBeNamed => $job->getName(),
                $job instanceof ShouldBeUnique => $job->uniqueId(),
                default => (new ReflectionClass($job))->getShortName()
            };
            $jobRecord = Job::find($event->id);

            $monitor = new Monitor();
            $monitor->name = $name;
            $monitor->uuid = $jobRecord->uuid();
            $monitor->status = MonitorStatusType::WAITING;
            $monitor->save();
        }
    }
}
