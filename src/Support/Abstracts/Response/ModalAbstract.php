<?php

    namespace Support\Abstracts\Response;

    use Support\Abstracts\Response\AbstractPopup;
    use Support\Enums\PopupTypes;

    abstract class ModalAbstract extends AbstractPopup
    {
        /**
         * @var array
         */
        protected array $data;

        /**
         * @return PopupTypes
         */
        public function getType(): PopupTypes
        {
            return PopupTypes::MODAL;
        }

        /**
         * @return array
         */
        public function getData(): array
        {
            return $this->data;
        }
    }
