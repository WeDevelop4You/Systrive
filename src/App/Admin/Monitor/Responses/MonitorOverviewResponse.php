<?php

namespace App\Admin\Monitor\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;

class MonitorOverviewResponse extends AbstractResponse
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
                    ->setRoutes('admin.monitor')
                    ->setTitle(trans('word.monitor'))
                    ->setVuexNamespace('monitors/dataTable')
                    ->setTotalPerPageOpOptions([100, 250, 500])
            );
    }
}
