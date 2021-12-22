<?php

    namespace Support\Helpers\Response\Popups\Modals;

    class FormModal extends ModalBase
    {
        public const CompanyForm = 'Company';

        /**
         * @inheritDoc
         */
        public function getComponent(): string
        {
            return 'FormModal';
        }

        /**
         * @param string $formComponent
         *
         * @return FormModal
         */
        public function setFormComponent(string $formComponent): FormModal
        {
            $this->data['form_component'] = $formComponent;

            return $this;
        }

        /**
         * @param int $maxWidth
         *
         * @return FormModal
         */
        public function setMaxWidth(int $maxWidth = 500): FormModal
        {
            $this->data['max_width'] = $maxWidth;

            return $this;
        }

        /**
         * @param $title
         *
         * @return FormModal
         */
        public function setTitle($title): FormModal
        {
            $this->data['title'] = $title;

            return $this;
        }

        /**
         * @param $saveText
         *
         * @return $this
         */
        public function setSaveText($saveText): FormModal
        {
            $this->data['saveText'] = $saveText;

            return $this;
        }

        /**
         * @param string $requestUrl
         *
         * @return FormModal
         */
        public function setRequestUrl(string $requestUrl): FormModal
        {
            $this->data['request_url'] = $requestUrl;

            return $this;
        }

        /**
         * @param string $RequestMethod
         *
         * @return FormModal
         */
        public function setRequestMethod(string $RequestMethod): FormModal
        {
            $this->data['request_method'] = $RequestMethod;

            return $this;
        }

        /**
         * @param string $url
         *
         * @return FormModal
         */
        public function setCancelUrl(string $url): FormModal
        {
            $this->data['cancel_url'] = $url;

            return $this;
        }

        /**
         * @param string $text
         *
         * @return FormModal
         */
        public function setCancelText(string $text): FormModal
        {
            $this->data['cancel_text'] = $text;

            return $this;
        }
    }
