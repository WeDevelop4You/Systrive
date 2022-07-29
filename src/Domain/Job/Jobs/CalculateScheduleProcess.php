<?php

namespace Domain\Job\Jobs;

use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Models\JobOperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateScheduleProcess implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public JobOperation $schedule
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($this->schedule->isParent()) {
            $ended = $this->schedule->children->lastEnded();
            $started = $this->schedule->children->firstStarted();
            $isSuccessfulRun = !$this->schedule->children->hasFailed();

            $this->schedule->end_time = $ended;
            $this->schedule->start_time = $started;
            $this->schedule->status = $isSuccessfulRun
                ? JobOperationStatusTypes::SUCCESS
                : JobOperationStatusTypes::FAILED;
            $this->schedule->save();
        }
    }
}
