<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Abstracts\Response\AbstractAction;

    class RouteMethods extends AbstractAction
    {
        /**
         * @param array|string $route
         *
         * @return RouteMethods
         */
        public function goToRoute(array|string $route): RouteMethods
        {
            return $this->setData(['route' => $route])->setMethod('actionGoToRoute');
        }

        /**
         * @return RouteMethods
         */
        public function goToLastRoute(): RouteMethods
        {
            return $this->setMethod('actionGoToLastRoute');
        }

        /**
         * @return RouteMethods
         */
        public function goToMainRoute(): RouteMethods
        {
            return $this->setMethod('actionGoToMainRoute');
        }
    }
