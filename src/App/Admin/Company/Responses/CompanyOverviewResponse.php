<?php

namespace App\Admin\Company\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;

class CompanyOverviewResponse extends AbstractResponse
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
                    ->setTitle(trans('word.companies'))
                    ->setVuexNamespace('companies/dataTable')
                    ->setHeaderRoute(route('admin.company.table.headers'))
                    ->setItemsRoute(route('admin.company.table.items'))
                    ->setPrependComponent(
                        ButtonComponent::create()
                            ->setSize()
                            ->setColor()
                            ->setTitle(trans('word.invite.invite'))
                            ->setAction(
                                VuexAction::create()
                                    ->dispatch('companies/create', route(
                                        'admin.company.invite'
                                    ))
                            )
                    )
            );
    }
}
