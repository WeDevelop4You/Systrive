<?php

namespace Domain\Monitor\Listeners;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Mappings\MonitorTableMap;
use Domain\Monitor\Models\Monitor;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Carbon;

class MonitorProcessed
{
    /**
     * Handle the event.
     *
     * @param JobProcessed $event
     *
     * @return void
     */
    public function handle(JobProcessed $event): void
    {
        $monitor = Monitor::firstWhere(MonitorTableMap::COL_UUID, $event->job->uuid());

        if ($monitor instanceof Monitor) {
            $monitor->status = MonitorStatusType::SUCCESS;
            $monitor->ended = Carbon::now()->getTimestampMs();
            $monitor->save();
        }
    }
}
