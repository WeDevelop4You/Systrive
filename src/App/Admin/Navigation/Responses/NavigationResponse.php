<?php

namespace App\Admin\Navigation\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Navbar\NavbarComponent;
use Support\Client\Components\Navbar\Navigations\GroupNavigationComponent;
use Support\Client\Components\Navbar\Navigations\Items\NavigationItemComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;

class NavigationResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                NavbarComponent::create()
                    ->setShaped()
                    ->addItem($this->createSuperAdminNavigationItems())
            );
    }

    private function createSuperAdminNavigationItems(): GroupNavigationComponent
    {
        return GroupNavigationComponent::create()
            ->setNavigation([
                NavigationItemComponent::create()
                    ->setTitle(trans('word.users'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USERS))
                    ->setRoute(VueRouteHelper::create()->setName('admin.users')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.companies'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_ADDRESS_CARD))
                    ->setRoute(VueRouteHelper::create()->setName('admin.companies')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.translations'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_LANGUAGE))
                    ->setRoute(VueRouteHelper::create()->setName('admin.translations')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.monitor'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_DESKTOP))
                    ->setRoute(VueRouteHelper::create()->setName('admin.monitor')),
                NavigationItemComponent::create()
                    ->setTitle(trans('word.supervisor'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_RUNNING))
                    ->setRoute(VueRouteHelper::create()->setName('admin.supervisor')),
            ]);
    }
}
