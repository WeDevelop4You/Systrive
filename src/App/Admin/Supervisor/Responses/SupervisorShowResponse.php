<?php

namespace App\Admin\Supervisor\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Overviews\Tables\LocaleTableComponent;
use Support\Client\Components\Popups\Modals\ShowModal;
use Support\Client\Response;

class SupervisorShowResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addPopup(
                ShowModal::create('supervisor')
                    ->setWidth(800)
                    ->setTitle(trans('word.process'))
                    ->addComponent(
                        LocaleTableComponent::create()
                            ->setFlat()
                            ->setSearchable()
                            ->setVuexNamespace('supervisor/dataTable')
                            ->setHeaderRoute(
                                route('admin.supervisor.table.headers')
                            )
                            ->setItemsRoute(
                                route('admin.supervisor.table.items')
                            )
                            ->setPrependComponent(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.create.create'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'supervisor/create',
                                            route('admin.supervisor.process.create')
                                        )
                                    )
                            )
                    )
            );
    }
}
