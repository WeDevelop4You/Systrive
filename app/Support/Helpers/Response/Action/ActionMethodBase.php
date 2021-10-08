<?php

    namespace Support\Helpers\Response\Action;

    abstract class ActionMethodBase
    {
        /**
         * @var array
         */
        protected array $content = [];

        abstract public function __construct();

        /**
         * @return array
         */
        final public function get(): array
        {
            return $this->content;
        }
    }
