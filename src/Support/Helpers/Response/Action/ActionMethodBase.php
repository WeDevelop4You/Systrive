<?php

    namespace Support\Helpers\Response\Action;

    abstract class ActionMethodBase
    {
        /**
         * @var array
         */
        protected array $content = [];

        /**
         * ActionMethodBase constructor.
         */
        abstract public function __construct();

        /**
         * @return ActionMethodBase
         */
        abstract public static function create(): ActionMethodBase;

        /**
         * @return array
         */
        final public function get(): array
        {
            return $this->content;
        }
    }
