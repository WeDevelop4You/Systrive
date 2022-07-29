<?php

namespace App\Admin\Job\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;

class JobOverviewResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                ServerTableComponent::create()
                    ->setSearchable()
                    ->setTitle(trans('word.jobs.schedule'))
                    ->setVuexNamespace('jobs/schedules')
                    ->setHeaderUrl(route('admin.admin.job.schedule.table.headers'))
                    ->setItemsUrl(route('admin.admin.job.schedule.table.items'))
                    ->setPrependComponent(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.processes'))
                            ->setAction(
                                RequestAction::create()->get(
                                    route('admin.admin.job.process.show')
                                )
                            )
                    )
            );
    }
}
