<?php

namespace App\Admin\Startup\Responses;

use App\Admin\Account\Responses\AccountSettingsOverviewResponse;
use Support\Abstracts\AbstractResponse;
use Support\Enums\IconTypes;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Components\Navbar\NavbarComponent;
use Support\Response\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Response\Components\Navbar\Navigations\Items\NavigationCustomItemComponent;
use Support\Response\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Response\Response;

class SubNavigationResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                NavbarComponent::create()
                    ->setNav()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->setNavigation([
                                NavigationItemComponent::create()
                                    ->setTitle(trans('word.account.account'))
                                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_USER_CIRCLE))
                                    ->setRoute(
                                        VueRouteHelper::create()->setName('account')
                                    ),
                                NavigationItemComponent::create()
                                    ->setTitle(trans('word.settings'))
                                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_COG))
                                    ->setRoute(
                                        VueRouteHelper::create()
                                            ->setName('account.settings')
                                            ->setParams([
                                                'page' => AccountSettingsOverviewResponse::DEFAULT_PAGE,
                                            ])
                                    ),
                            ])
                    )
                    ->addDivider()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->addNavigation(
                                NavigationCustomItemComponent::create()
                                    ->setTitle(trans('word.dark.mode'))
                                    ->setType('DarkModeSwitch')
                            )
                    )
                    ->addDivider()
                    ->addItem(
                        GroupNavigationComponent::create()
                            ->addNavigation(
                                NavigationItemComponent::create()
                                    ->setTitle(trans('word.logout'))
                                    ->setPrepend(IconComponent::create()->setType(IconTypes::FAS_SIGN_OUT_ALT))
                                    ->setAction(
                                        VuexAction::create()->dispatch('user/auth/logout')
                                    )
                            )
                    )
            );
    }
}
