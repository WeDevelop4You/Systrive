<?php

namespace Support\Response\Components\Popups\Modals;

use Ramsey\Uuid\UuidInterface;
use Support\Response\Components\Overviews\CardComponent;

abstract class AbstractModal
{
    /**
     * @var CardComponent
     */
    protected CardComponent $card;

    /**
     * @var ModalComponent
     */
    protected ModalComponent $modal;

    /**
     * AbstractModal constructor.
     */
    protected function __construct()
    {
        $this->card = CardComponent::create();
        $this->modal = ModalComponent::create();

        $this->initializeCard();
        $this->initializeModal();
    }

    /**
     * @param mixed ...$arguments
     *
     * @return static
     */
    public static function create(...$arguments): static
    {
        return new static(...$arguments);
    }

    /**
     * @return ModalComponent
     */
    public function getModal(): ModalComponent
    {
        return $this->modal;
    }

    /**
     * @return UuidInterface
     */
    public function getIdentifier(): UuidInterface
    {
        return $this->modal->getIdentifier();
    }

    /**
     * @return CardComponent
     */
    public function getCard(): CardComponent
    {
        return $this->card;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return $this->modal
            ->setCard($this->card)
            ->export();
    }

    abstract protected function initializeModal(): void;

    abstract protected function initializeCard(): void;
}
