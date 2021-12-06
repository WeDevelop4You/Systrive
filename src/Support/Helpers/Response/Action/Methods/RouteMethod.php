<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Helpers\Response\Action\ActionMethodBase;

    class RouteMethod extends ActionMethodBase
    {
        /**
         * RouteMethod constructor.
         */
        public function __construct()
        {
            //
        }

        /**
         * @return RouteMethod
         */
        public static function create(): RouteMethod
        {
            return new static();
        }

        /**
         * @param array $route
         *
         * @return RouteMethod
         */
        public function goToRoute(array $route): RouteMethod
        {
            $this->content = [
                'method' => 'actionGoToRoute',
                'parameters' => [
                    $route,
                ],
            ];

            return $this;
        }

        /**
         * @return RouteMethod
         */
        public function goToLastRoute(): RouteMethod
        {
            $this->content = [
                'method' => 'actionGoToLastRoute',
            ];

            return $this;
        }

        /**
         * @return RouteMethod
         */
        public function goToMainRoute(): RouteMethod
        {
            $this->content = [
                'method' => 'actionGoToMainRoute',
            ];

            return $this;
        }
    }
