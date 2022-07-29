<?php

namespace App\Admin\Job\Responses;

use Domain\Job\Models\JobOperation;
use Support\Abstracts\AbstractResponse;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

class JobShowResponse extends AbstractResponse
{
    public function __construct(
        private readonly ?JobOperation $scheduleJob
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        if ($this->scheduleJob instanceof JobOperation) {
            $headerRoute = route('admin.admin.job.schedule.process.table.headers', [
                $this->scheduleJob->id,
            ]);
            $itemRoute = route('admin.admin.job.schedule.process.table.items', [
                $this->scheduleJob->id,
            ]);
        } else {
            $headerRoute = route('admin.admin.job.process.table.headers');
            $itemRoute = route('admin.admin.job.process.table.items');
        }

        return Response::create()
            ->addPopup(
                ShowModal::create('jobs')
                    ->setWidth(1100)
                    ->setTitle(trans('word.jobs.process'))
                    ->addComponent(
                        ServerTableComponent::create()
                            ->setFlat()
                            ->setSearchable()
                            ->setTotalPerPageOpOptions([50, 100, 250, 500])
                            ->setTotalPerPage(50)
                            ->setVuexNamespace('jobs/processes')
                            ->setHeaderUrl($headerRoute)
                            ->setItemsUrl($itemRoute)
                    )
            );
    }
}
