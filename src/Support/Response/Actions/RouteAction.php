<?php

    namespace Support\Response\Actions;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Http\Request;
    use Support\Response\Components\Navbar\Helpers\VueRouteHelper;

    class RouteAction extends AbstractAction
    {
        /**
         * @param VueRouteHelper $route
         *
         * @return RouteAction
         */
        public function goTo(VueRouteHelper $route): RouteAction
        {
            return $this->setData(['route' => $route->export()])
                ->setMethod('actionGoToRoute');
        }

        /**
         * @return RouteAction
         */
        public function goToLastRoute(): RouteAction
        {
            try {
                /** @var Request $request */
                $request = Container::getInstance()->make('request');
            } catch (BindingResolutionException) {
                //Do nothing
            }

            $lastRouteName = $request->header('X-Last-Route-Name');

            if (\is_null($lastRouteName)) {
                return $this->goToDashboard();
            }

            return $this->goTo(VueRouteHelper::create()->setName($lastRouteName));
        }

        /**
         * @return RouteAction
         */
        public function goToDashboard(): RouteAction
        {
            return $this->goTo(VueRouteHelper::create()->setName('dashboard'));
        }
    }
