<?php

namespace Support\Listeners;

use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Jobs\CalculateScheduleProcess;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Carbon;

class EndJobOperator
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
        JobOperation::where(
            JobOperationTableMap::UUID,
            $event->job->uuid(),
        )->update([
            JobOperationTableMap::STATUS => JobOperationStatusTypes::SUCCESS,
            JobOperationTableMap::END_TIME => Carbon::now()->getTimestampMs(),
        ]);

        if (!($event->job->resolveName() instanceof CalculateScheduleProcess)) {
            $schedule = JobOperation::whereScheduleWithChildUuid($event->job->uuid())->first();

            CalculateScheduleProcess::dispatchIf(
                $schedule instanceof JobOperation,
                $schedule
            );
        }
    }
}
