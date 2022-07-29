<?php

namespace Support\Listeners;

use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Carbon;

class StartJobOperator
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
        JobOperation::where(
            JobOperationTableMap::UUID,
            $event->job->uuid(),
        )->update([
            JobOperationTableMap::STATUS => JobOperationStatusTypes::PROCESSING,
            JobOperationTableMap::START_TIME => Carbon::now()->getTimestampMs(),
        ]);
    }
}
