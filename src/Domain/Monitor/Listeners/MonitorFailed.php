<?php

namespace Domain\Monitor\Listeners;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Mappings\MonitorTableMap;
use Domain\Monitor\Models\Monitor;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Carbon;

class MonitorFailed
{
    /**
     * Handle the event.
     *
     * @param JobFailed $event
     *
     * @return void
     */
    public function handle(JobFailed $event): void
    {
        $monitor = Monitor::firstWhere(MonitorTableMap::COL_UUID, $event->job->uuid());

        if ($monitor instanceof Monitor) {
            $monitor->status = MonitorStatusType::FAILED;
            $monitor->ended = Carbon::now()->getTimestampMs();
            $monitor->save();
        }
    }
}
