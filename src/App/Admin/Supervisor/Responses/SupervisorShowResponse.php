<?php

namespace App\Admin\Supervisor\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Overviews\Tables\LocaleTableComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

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
                            ->setVuexNamespace('supervisor')
                            ->setHeaderUrl(
                                route('admin.admin.supervisor.table.headers')
                            )
                            ->setItemsUrl(
                                route('admin.admin.supervisor.table.items')
                            )
                            ->setPrependComponent(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.create.create'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'supervisor/create',
                                            route('admin.admin.supervisor.process.create')
                                        )
                                    )
                            )
                    )
            );
    }
}
