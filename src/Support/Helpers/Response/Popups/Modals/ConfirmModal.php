<?php

    namespace Support\Helpers\Response\Popups\Modals;

    use Support\Abstracts\Response\ModalAbstract;
    use Support\Helpers\Response\Popups\Components\Button;

    class ConfirmModal extends ModalAbstract
    {
        public function getComponent(): string
        {
            return 'ConfirmModal';
        }

        /**
         * @param string $title
         *
         * @return ConfirmModal
         */
        public function setTitle(string $title): ConfirmModal
        {
            $this->data['title'] = $title;

            return $this;
        }

        /**
         * @param string $text
         *
         * @return ConfirmModal
         */
        public function setText(string $text): ConfirmModal
        {
            $this->data['text'] = $text;

            return $this;
        }

        /**
         * @param Button $button
         *
         * @return ConfirmModal
         */
        public function addButton(Button $button): ConfirmModal
        {
            $this->data['buttons'][] = $button->export();

            return $this;
        }
    }
