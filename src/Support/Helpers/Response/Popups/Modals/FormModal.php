<?php

    namespace Support\Helpers\Response\Popups\Modals;

    use Support\Abstracts\Response\ModalAbstract;
    use Support\Enums\FormTypes;
    use Support\Helpers\Response\Popups\Components\Button;

    class FormModal extends ModalAbstract
    {
        /**
         * @inheritDoc
         */
        public function getComponent(): string
        {
            return 'FormModal';
        }

        /**
         * @param FormTypes $formComponent
         *
         * @return FormModal
         */
        public function setFormComponent(FormTypes $formComponent): FormModal
        {
            $this->data['form_component'] = $formComponent;

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
         * @param int $maxWidth
         *
         * @return FormModal
         */
        public function setMaxWidth(int $maxWidth): FormModal
        {
            $this->data['max_width'] = $maxWidth;

            return $this;
        }

        /**
         * @param Button $button
         *
         * @return FormModal
         */
        public function addButton(Button $button): FormModal
        {
            $this->data['buttons'][] = $button->export();

            return $this;
        }
    }
