<?php

    namespace Support\Abstracts;

    abstract class AbstractTable
    {
        /**
         * @return array
         */
        final public static function create(): array
        {
            $instance = new static();

            return $instance->columns();
        }

        /**
         * @return array
         */
        abstract protected function columns(): array;
    }
