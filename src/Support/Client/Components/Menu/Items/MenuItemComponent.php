<?php

namespace Support\Client\Components\Menu\Items;

use Support\Client\Actions\Action;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Enums\Component\TargetType;

class MenuItemComponent extends AbstractMenuItemComponent
{
    /**
     * @param string $title
     *
     * @return MenuItemComponent
     */
    public function setTitle(string $title): MenuItemComponent
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param string $description
     *
     * @return MenuItemComponent
     */
    public function setDescription(string $description): MenuItemComponent
    {
        return $this->setContent('description', $description);
    }

    /**
     * @param IconComponent|ImageComponent $component
     *
     * @return MenuItemComponent
     */
    public function setPrepend(IconComponent|ImageComponent $component): MenuItemComponent
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param VueRouteHelper $route
     *
     * @return MenuItemComponent
     */
    public function setRoute(VueRouteHelper $route): MenuItemComponent
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
     * @return MenuItemComponent
     */
    public function setHref(string $route, TargetType $target = TargetType::BLANK): MenuItemComponent
    {
        return $this->setAttribute('href', $route)
            ->setAttribute('target', $target->value)
            ->setData('action', null)
            ->setAttribute('to', null);
    }

    /**
     * @param Action $action
     *
     * @return MenuItemComponent
     */
    public function setAction(Action $action): MenuItemComponent
    {
        return $this->setData('action', $action->export())
            ->setAttribute('to', null)
            ->setAttribute('href', null)
            ->setAttribute('target', null);
    }
}
