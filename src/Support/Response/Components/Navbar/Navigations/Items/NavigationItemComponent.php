<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Actions\AbstractAction;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Images\ImageComponent;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;

class NavigationItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
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
        return $this->setAttribute('to', $route->export());
    }

    /**
     * @param AbstractAction $action
     *
     * @return NavigationItemComponent
     */
    public function setAction(AbstractAction $action): NavigationItemComponent
    {
        return $this->setData('action', $action->export());
    }
}
