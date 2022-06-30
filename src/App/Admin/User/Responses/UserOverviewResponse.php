<?php

namespace App\Admin\User\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Response;

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
                    ->setVuexNamespace('users')
                    ->setHeaderUrl(route('admin.admin.user.table.headers'))
                    ->setItemsUrl(route('admin.admin.user.table.items'))
            );
    }
}
