<?php

namespace Support\Client\Components\Popups\Modals;

use Ramsey\Uuid\UuidInterface;
use Support\Client\Components\Overviews\CardComponent;

abstract class AbstractModal
{
    /**
     * @var CardComponent
     */
    protected CardComponent $card;

    /**
     * @var DialogComponent
     */
    protected DialogComponent $modal;

    /**
     * AbstractModal constructor.
     */
    protected function __construct()
    {
        $this->card = CardComponent::create();
        $this->modal = DialogComponent::create();

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
     * @return DialogComponent
     */
    public function getModal(): DialogComponent
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
            ->setModal($this->card)
            ->export();
    }

    abstract protected function initializeModal(): void;

    abstract protected function initializeCard(): void;
}
