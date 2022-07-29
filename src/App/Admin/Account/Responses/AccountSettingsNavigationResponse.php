<?php

namespace App\Admin\Account\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\IconTypes;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Components\Navbar\NavbarComponent;
use Support\Response\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Response\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Response;

class AccountSettingsNavigationResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                CardComponent::create()
                    ->setTitle(trans('word.account.settings'))
                    ->addAdditionalBodyClass('pa-0')
                    ->addBody(
                        NavbarComponent::create()
                            ->setNav()
                            ->addItem(
                                GroupNavigationComponent::create()
                                    ->setNavigation([
                                        NavigationItemComponent::create()
                                            ->setTitle(trans('word.personal.data'))
                                            ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_USER))
                                            ->setRoute(VueRouteHelper::getAccountSettings('personal')),
                                        NavigationItemComponent::create()
                                            ->setTitle(trans('word.security'))
                                            ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_SHIELD_ALT))
                                            ->setRoute(VueRouteHelper::getAccountSettings('security')),
                                        NavigationItemComponent::create()
                                            ->setTitle(trans('word.git.account'))
                                            ->setPrepend(IconComponent::create()->setType(IconTypes::FAB_GIT_ALT))
                                            ->setRoute(VueRouteHelper::getAccountSettings('git')),
                                    ])
                            )
                    )
            );
    }
}