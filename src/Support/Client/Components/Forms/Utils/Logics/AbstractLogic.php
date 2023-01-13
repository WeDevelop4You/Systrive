<?php

namespace Support\Client\Components\Forms\Utils\Logics;

abstract class AbstractLogic
{
    /**
     * @var array
     */
    private array $data = [];

    /**
     * Contain constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->setData('key', $key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    protected function setData(string $key, mixed $value): static
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'type' => $this->type(),
            'data' => $this->data,
        ];
    }

    /**
     * @return string
     */
    abstract protected function type(): string;
}
