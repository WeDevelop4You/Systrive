<?php

namespace App\Account\Settings\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Overviews\PageComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

class SettingsOverviewResponse extends AbstractResponse
{
    public const DEFAULT_PAGE = 'personal';

    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->setJustify(VuetifyJustifyType::CENTER)
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
                    ->setVuexNamespace('settings/navigation')
                    ->setRoute(route('account.settings.navigation'))
            );
    }

    private function createPageOverview(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(7)
            ->setComponent(
                PageComponent::create()
                    ->setVuexNamespace('settings/page')
            );
    }
}
