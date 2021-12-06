<?php

    namespace Support\Helpers\Response\Popups\Modals;

    use Support\Helpers\Response\Popups\PopupBase;

    abstract class ModalBase extends PopupBase
    {
        /**
         * @var array
         */
        protected array $data;

        /**
         * @param ...$data
         *
         * @return static
         */
        public static function create(...$data): static
        {
            return new static(...$data);
        }

        /**
         * @return string
         */
        public function getType(): string
        {
            return self::MODAL_TYPE;
        }

        /**
         * @return array
         */
        public function getData(): array
        {
            return $this->data;
        }
    }
