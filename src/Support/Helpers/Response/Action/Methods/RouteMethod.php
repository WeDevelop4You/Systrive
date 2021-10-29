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

        public function setGoToRoute(array $route): void
        {
            $this->content = [
                'method' => 'actionGoToRoute',
                'parameters' => [
                    $route,
                ],
            ];
        }

        public function setActionGoToLastRoute(): void
        {
            $this->content = [
                'method' => 'actionGoToLastRoute',
            ];
        }
    }
