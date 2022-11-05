<?php

    namespace Support\Response\Components\Popups\Modals;

    use Support\Enums\Component\PopupType;
    use Support\Enums\Component\Vuetify\VuetifyTransitionType;
    use Support\Response\Actions\AbstractAction;
    use Support\Response\Components\Overviews\CardComponent;
    use Support\Response\Components\Popups\AbstractPopupComponent;

    class ModalComponent extends AbstractPopupComponent
    {
        protected function getComponentName(): string
        {
            return 'modalComponent';
        }

        /**
         * @return PopupType
         */
        protected function getType(): PopupType
        {
            return PopupType::MODAL;
        }

        /**
         * @param int|string $width
         *
         * @return static
         */
        public function setWidth(string|int $width): static
        {
            return $this->setAttribute('width', $width);
        }

        /**
         * @return static
         */
        public function setPersistent(): static
        {
            return $this->setAttribute('persistent', true);
        }

        /**
         * @return static
         */
        public function setFullscreen(): static
        {
            return $this->setAttribute('fullscreen', true);
        }

        /**
         * @return static
         */
        public function setHideOverlay(): static
        {
            return $this->setAttribute('hide-overlay', true);
        }

        /**
         * @return static
         */
        public function setNoClickAnimation(): static
        {
            return $this->setAttribute('no-click-animation', true);
        }

        /**
         * @return static
         */
        public function setScrollable(): static
        {
            return $this->setAttribute('scrollable', true);
        }

        /**
         * @param VuetifyTransitionType $transition
         *
         * @return static
         */
        public function setTransition(VuetifyTransitionType $transition): static
        {
            return $this->setAttribute('transition', $transition->value);
        }

        /**
         * @param CardComponent $card
         *
         * @return static
         */
        public function setCard(CardComponent $card): static
        {
            return $this->setData('card', $card->export());
        }

        /**
         * @param AbstractAction $action
         *
         * @return static
         */
        public function setOpenAction(AbstractAction $action): static
        {
            return $this->setData('openAction', $action->export());
        }

        /**
         * @param AbstractAction $action
         *
         * @return static
         */
        public function setCloseAction(AbstractAction $action): static
        {
            return $this->setData('closeAction', $action->export());
        }
    }
