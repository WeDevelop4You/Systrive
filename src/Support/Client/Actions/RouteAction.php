<?php

namespace Support\Client\Actions;

use Support\Client\Components\Menu\Helpers\VueRouteHelper;

class RouteAction extends Action
{
    /**
     * @param VueRouteHelper $route
     *
     * @return RouteAction
     */
    public function goTo(VueRouteHelper $route): RouteAction
    {
        return $this->setData(['route' => $route->export()])
            ->setName('goToRouteAction');
    }
}
