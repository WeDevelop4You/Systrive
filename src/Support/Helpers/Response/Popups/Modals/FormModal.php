<?php

    namespace Support\Helpers\Response\Popups\Modals;

    class FormModal extends ModalBase
    {
        /**
         * @inheritDoc
         */
        public function getComponent(): string
        {
            return 'Form';
        }
    }
