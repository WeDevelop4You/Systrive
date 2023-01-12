<?php

namespace Support\Client\Actions;

use Ramsey\Uuid\UuidInterface;

abstract class Action
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var Action|null
     */
    private Action|null $successAction = null;

    /**
     * @var Action|null
     */
    private Action|null $failAction = null;

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    final protected function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    final protected function setData(array $data, bool $isArray = false): static
    {
        $isArray ? $this->data[] = $data : $this->data = $data;

        return $this;
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    final public function setOnSuccessAction(Action $action): static
    {
        $this->successAction = $action;

        return $this;
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    final public function setOnFailAction(Action $action): static
    {
        $this->failAction = $action;

        return $this;
    }

    /**
     * @param UuidInterface|null $identifier
     *
     * @return $this
     */
    final public function setCloseModalOnSuccessAction(UuidInterface|null $identifier = null): static
    {
        $this->successAction = VuexAction::create()->closeModal($identifier);

        return $this;
    }

    /**
     * @param UuidInterface|null $identifier
     *
     * @return $this
     */
    final public function setCloseModalOnFailAction(UuidInterface|null $identifier = null): static
    {
        $this->failAction = VuexAction::create()->closeModal($identifier);

        return $this;
    }

    /**
     * @return array
     */
    final public function export(): array
    {
        return [
            'data' => $this->data,
            'name' => $this->name,
            'failAction' => $this->failAction?->export(),
            'successAction' => $this->successAction?->export(),
        ];
    }
}
