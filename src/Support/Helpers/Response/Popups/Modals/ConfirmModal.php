<?php

    namespace Support\Helpers\Response\Popups\Modals;

    class ConfirmModal extends ModalBase
    {
        public function getComponent(): string
        {
            return 'Confirm';
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
         * @param string $url
         *
         * @return ConfirmModal
         */
        public function setAcceptUrl(string $url): ConfirmModal
        {
            $this->data['accept_url'] = $url;

            return $this;
        }

        /**
         * @param string $text
         *
         * @return ConfirmModal
         */
        public function setAcceptText(string $text): ConfirmModal
        {
            $this->data['accept_text'] = $text;

            return $this;
        }

        /**
         * @param string $url
         *
         * @return $this
         */
        public function setCancelUrl(string $url): ConfirmModal
        {
            $this->data['cancel_url'] = $url;

            return $this;
        }

        /**
         * @param string $text
         *
         * @return ConfirmModal
         */
        public function setCancelText(string $text): ConfirmModal
        {
            $this->data['cancel_text'] = $text;

            return $this;
        }
    }
