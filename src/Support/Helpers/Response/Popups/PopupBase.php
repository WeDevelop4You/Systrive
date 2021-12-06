<?php

    namespace Support\Helpers\Response\Popups;

    abstract class PopupBase
    {
        public const MODAL_TYPE = 'modal';
        public const NOTIFICATION_TYPE = 'notification';

        /**
         * @param ...$data
         *
         * @return static
         */
        abstract public static function create(...$data): static;

        /**
         * @return string
         */
        abstract public function getType(): string;

        /**
         * @return string
         */
        abstract public function getComponent(): string;

        /**
         * @return array
         */
        abstract public function getData(): array;
    }
