<?php

    namespace Support\Helpers\Response\Action;

    class ActionContent
    {
        /**
         * @var ActionMethodBase
         */
        private ActionMethodBase $method;

        /**
         * @param ActionMethodBase $methodClass
         */
        public function __construct(ActionMethodBase $methodClass)
        {
            $this->method = new $methodClass();
        }

        /**
         * @return ActionMethodBase
         */
        public function getMethod(): ActionMethodBase
        {
            return $this->method;
        }

        /**
         * @return array
         */
        public function create(): array
        {
            return $this->method->get();
        }
    }
