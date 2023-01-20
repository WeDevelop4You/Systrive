<?php

namespace Support\Client\Components\Navbar\Navigations\Items;

use Support\Client\Actions\Action;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;

class NavigationCreateItemComponent extends AbstractNavigationItemComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'NavigationCreateItemComponent';
    }

    /**
     * @param VueRouteHelper $route
     *
     * @return NavigationCreateItemComponent
     */
    public function setRoute(VueRouteHelper $route): NavigationCreateItemComponent
    {
        return $this->setAttribute('to', $route->export());
    }

    /**
     * @param Action $action
     *
     * @return NavigationCreateItemComponent
     */
    public function setAction(Action $action): NavigationCreateItemComponent
    {
        return $this->setData('action', $action->export());
    }
}
