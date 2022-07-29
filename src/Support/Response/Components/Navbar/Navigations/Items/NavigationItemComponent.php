<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Actions\AbstractAction;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;

class NavigationItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NavigationItem';
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
