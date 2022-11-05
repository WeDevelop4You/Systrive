<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Actions\AbstractAction;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;

class NavigationCreateItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
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
     * @param AbstractAction $action
     *
     * @return NavigationCreateItemComponent
     */
    public function setAction(AbstractAction $action): NavigationCreateItemComponent
    {
        return $this->setData('action', $action->export());
    }
}
