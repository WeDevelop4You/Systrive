<?php

namespace App\Account\Settings\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Components\Menu\Types\GroupMenuTypeComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;

class SettingsNavigationResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                CardComponent::create()
                    ->addAdditionalBodyClass('pa-0')
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.account.settings'))
                    )
                    ->addBody(
                        MenuComponent::create()
                            ->setNav()
                            ->addType(
                                GroupMenuTypeComponent::create()
                                    ->addItems([
                                        MenuItemComponent::create()
                                            ->setTitle(trans('word.personal.data'))
                                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_USER))
                                            ->setRoute(VueRouteHelper::createAccountSettings('personal')),
                                        MenuItemComponent::create()
                                            ->setTitle(trans('word.security'))
                                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_SHIELD_ALT))
                                            ->setRoute(VueRouteHelper::createAccountSettings('security')),
                                        //                                        NavigationItemComponent::create()
                                        //                                            ->setTitle(trans('word.git.account'))
                                        //                                            ->setPrepend(IconComponent::create()->setType(IconType::FAB_GIT_ALT))
                                        //                                            ->setRoute(VueRouteHelper::createAccountSettings('git')),
                                    ])
                            )
                    )
            );
    }
}
