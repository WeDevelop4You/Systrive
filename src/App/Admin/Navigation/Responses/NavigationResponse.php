<?php

namespace App\Admin\Navigation\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Components\Menu\Types\GroupMenuTypeComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;

class NavigationResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                MenuComponent::create()
                    ->setShaped()
                    ->addType($this->createSuperAdminNavigationItems())
            );
    }

    private function createSuperAdminNavigationItems(): GroupMenuTypeComponent
    {
        return GroupMenuTypeComponent::create()
            ->addItems([
                MenuItemComponent::create()
                    ->setTitle(trans('word.users'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_USERS))
                    ->setRoute(VueRouteHelper::create()->setName('admin.users')),
                MenuItemComponent::create()
                    ->setTitle(trans('word.companies'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_ADDRESS_CARD))
                    ->setRoute(VueRouteHelper::create()->setName('admin.companies')),
                MenuItemComponent::create()
                    ->setTitle(trans('word.translations'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_LANGUAGE))
                    ->setRoute(VueRouteHelper::create()->setName('admin.translations')),
                MenuItemComponent::create()
                    ->setTitle(trans('word.monitor'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_DESKTOP))
                    ->setRoute(VueRouteHelper::create()->setName('admin.monitor')),
                MenuItemComponent::create()
                    ->setTitle(trans('word.supervisor'))
                    ->setPrepend(IconComponent::create()->setType(IconType::FAS_RUNNING))
                    ->setRoute(VueRouteHelper::create()->setName('admin.supervisor')),
            ]);
    }
}
