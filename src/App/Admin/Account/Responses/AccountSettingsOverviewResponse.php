<?php

namespace App\Admin\Account\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Vuetify\VuetifyJustifyTypes;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\PageComponent;
use Support\Response\Response;

class AccountSettingsOverviewResponse extends AbstractResponse
{
    public const DEFAULT_PAGE = 'personal';

    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->setJustify(VuetifyJustifyTypes::CENTER)
                    ->setCols([
                        $this->createNavbar(),
                        $this->createPageOverview(),
                    ])
            );
    }

    private function createNavbar(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(3)
            ->setComponent(
                PageComponent::create()
                    ->setVuexNamespace('user/auth/settings/navigation')
                    ->setRoute(route('admin.account.settings.navigation'))
            );
    }

    private function createPageOverview(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(7)
            ->setComponent(
                PageComponent::create()
                    ->setVuexNamespace('user/auth/settings/page')
            );
    }
}
