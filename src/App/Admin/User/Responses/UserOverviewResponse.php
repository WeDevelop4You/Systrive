<?php

namespace App\Admin\User\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Response;

class UserOverviewResponse extends AbstractResponse
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
                    ->setTitle(trans('word.users'))
                    ->setVuexNamespace('users/dataTable')
                    ->setHeaderRoute(route('admin.user.table.headers'))
                    ->setItemsRoute(route('admin.user.table.items'))
            );
    }
}
