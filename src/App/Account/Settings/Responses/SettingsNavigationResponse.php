<?php

namespace App\Account\Settings\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Navbar\NavbarComponent;
use Support\Client\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;

class SettingsNavigationResponse extends AbstractResponse
{
    /**
     * @inheritDoc
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
                        NavbarComponent::create()
                            ->setNav()
                            ->addItem(
                                GroupNavigationComponent::create()
                                    ->setNavigation([
                                        NavigationItemComponent::create()
                                            ->setTitle(trans('word.personal.data'))
                                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_USER))
                                            ->setRoute(VueRouteHelper::createAccountSettings('personal')),
                                        NavigationItemComponent::create()
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
