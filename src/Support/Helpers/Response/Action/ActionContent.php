<?php

    namespace Support\Helpers\Response\Action;

    class ActionContent
    {
        /**
         * ActionContent constructor.
         *
         * @param ActionMethodBase $instance
         */
        public function __construct(
            private ActionMethodBase $instance
        ) {
            //
        }

        /**
         * @param ActionMethodBase $instance
         *
         * @return static
         */
        public static function create(ActionMethodBase $instance): ActionContent
        {
            return new static($instance);
        }

        /**
         * @return ActionMethodBase
         */
        public function getMethod(): ActionMethodBase
        {
            return $this->instance;
        }

        /**
         * @return array
         */
        public function getData(): array
        {
            return $this->instance->getData();
        }
    }
