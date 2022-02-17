<?php

    namespace Support\Abstracts\Response;

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

        /**
         * @return $this
         */
        public function setDismissible(): static
        {
            $this->data['isDismissible'] = true;

            return $this;
        }

        /**
         * @param AbstractAction $action
         *
         * @return $this
         */
        public function setOpenAction(AbstractAction $action): static
        {
            $this->data['openAction'] = $action->export();

            return $this;
        }

        /**
         * @param AbstractAction $action
         *
         * @return $this
         */
        public function setCloseAction(AbstractAction $action): static
        {
            $this->data['closeAction'] = $action->export();

            return $this;
        }
    }
