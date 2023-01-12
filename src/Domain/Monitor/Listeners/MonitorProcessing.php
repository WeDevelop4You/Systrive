<?php

namespace Domain\Monitor\Listeners;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Mappings\MonitorTableMap;
use Domain\Monitor\Models\Monitor;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Carbon;

class MonitorProcessing
{
    /**
     * Handle the event.
     *
     * @param JobProcessing $event
     *
     * @return void
     */
    public function handle(JobProcessing $event): void
    {
        $monitor = Monitor::firstWhere(MonitorTableMap::COL_UUID, $event->job->uuid());

        if ($monitor instanceof Monitor) {
            $monitor->status = MonitorStatusType::PROCESSING;
            $monitor->started = Carbon::now()->getTimestampMs();
            $monitor->save();
        }
    }
}
