<?php

namespace Support\Client\Components\Menu\Items;

use Support\Client\Actions\Action;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;

class CreateMenuItemComponent extends AbstractMenuItemComponent
{
    /**
     * @param VueRouteHelper $route
     *
     * @return CreateMenuItemComponent
     */
    public function setRoute(VueRouteHelper $route): CreateMenuItemComponent
    {
        return $this->setAttribute('to', $route->export());
    }

    /**
     * @param Action $action
     *
     * @return CreateMenuItemComponent
     */
    public function setAction(Action $action): CreateMenuItemComponent
    {
        return $this->setData('action', $action->export());
    }
}
