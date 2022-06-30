<?php

namespace App\Admin\Company\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;

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
                    ->setVuexNamespace('companies')
                    ->setHeaderUrl(route('admin.admin.company.table.headers'))
                    ->setItemsUrl(route('admin.admin.company.table.items'))
                    ->setPrependComponent(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.create.create'))
                            ->setAction(
                                VuexAction::create()
                                    ->dispatch('companies/create', route(
                                        'admin.admin.company.invite'
                                    ))
                            )
                    )
            );
    }
}
