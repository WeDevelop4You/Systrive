<?php

namespace Support\Response\Actions;

use Ramsey\Uuid\UuidInterface;

abstract class AbstractAction
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var AbstractAction|null
     */
    private AbstractAction|null $successAction = null;

    /**
     * @var AbstractAction|null
     */
    private AbstractAction|null $failAction = null;

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    final protected function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    final protected function setData(array $data, bool $isArray = false): static
    {
        $isArray ? $this->data[] = $data : $this->data = $data;

        return $this;
    }

    /**
     * @param AbstractAction $action
     *
     * @return $this
     */
    final public function setOnSuccessAction(AbstractAction $action): static
    {
        $this->successAction = $action;

        return $this;
    }

    /**
     * @param AbstractAction $action
     *
     * @return $this
     */
    final public function setOnFailAction(AbstractAction $action): static
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
            'method' => $this->method,
            'failAction' => $this->failAction?->export(),
            'successAction' => $this->successAction?->export(),
        ];
    }
}
