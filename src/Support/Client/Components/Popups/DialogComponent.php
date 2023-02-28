<?php

namespace Support\Client\Components\Popups;

use Support\Client\Actions\Action;
use Support\Client\Definitions\ModalComponentType;
use Support\Enums\Component\PopupType;
use Support\Enums\Component\Vuetify\VuetifyTransitionType;

class DialogComponent extends AbstractPopupComponent
{
    protected function getComponentName(): string
    {
        return 'dialogComponent';
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
     * @param ModalComponentType $modal
     *
     * @return static
     */
    public function setModal(ModalComponentType $modal): static
    {
        return $this->setData('modal', $modal->export());
    }

    /**
     * @param Action $action
     *
     * @return static
     */
    public function setOpenAction(Action $action): static
    {
        return $this->setData('openAction', $action->export());
    }

    /**
     * @param Action $action
     *
     * @return static
     */
    public function setCloseAction(Action $action): static
    {
        return $this->setData('closeAction', $action->export());
    }
}
