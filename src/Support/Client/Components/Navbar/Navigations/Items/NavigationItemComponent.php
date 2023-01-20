<?php

namespace Support\Client\Components\Navbar\Navigations\Items;

use Support\Client\Actions\Action;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Enums\Component\TargetType;

class NavigationItemComponent extends AbstractNavigationItemComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'NavigationItemComponent';
    }

    /**
     * @param string $title
     *
     * @return NavigationItemComponent
     */
    public function setTitle(string $title): NavigationItemComponent
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param string $description
     *
     * @return NavigationItemComponent
     */
    public function setDescription(string $description): NavigationItemComponent
    {
        return $this->setContent('description', $description);
    }

    /**
     * @param IconComponent|ImageComponent $component
     *
     * @return NavigationItemComponent
     */
    public function setPrepend(IconComponent|ImageComponent $component): NavigationItemComponent
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param VueRouteHelper $route
     *
     * @return NavigationItemComponent
     */
    public function setRoute(VueRouteHelper $route): NavigationItemComponent
    {
        return $this->setAttribute('to', $route->export())
            ->setAttribute('href', null)
            ->setAttribute('target', null)
            ->setData('action', null);
    }

    /**
     * @param string     $route
     * @param TargetType $target
     *
     * @return NavigationItemComponent
     */
    public function setHref(string $route, TargetType $target = TargetType::BLANK): NavigationItemComponent
    {
        return $this->setAttribute('href', $route)
            ->setAttribute('target', $target->value)
            ->setData('action', null)
            ->setAttribute('to', null);
    }

    /**
     * @param Action $action
     *
     * @return NavigationItemComponent
     */
    public function setAction(Action $action): NavigationItemComponent
    {
        return $this->setData('action', $action->export())
            ->setAttribute('to', null)
            ->setAttribute('href', null)
            ->setAttribute('target', null);
    }
}
