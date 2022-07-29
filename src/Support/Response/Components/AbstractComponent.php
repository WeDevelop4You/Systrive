<?php

namespace Support\Response\Components;

use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractComponent
{
    /**
     * @var UuidInterface
     */
    private UuidInterface $identifier;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var array
     */
    private array $content = [];

    /**
     * @var array
     */
    private array $attributes = [];

    protected function __construct()
    {
        $this->identifier = Str::uuid();
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @return string
     */
    abstract protected function getComponentName(): string;

    /**
     * @return UuidInterface
     */
    public function getIdentifier(): UuidInterface
    {
        return $this->identifier;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @param bool   $isArray
     *
     * @return static
     */
    protected function setData(string $name, mixed $value, bool $isArray = false): static
    {
        $isArray ? $this->data[$name][] = $value : $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return static
     */
    protected function setContent(string $name, mixed $value): static
    {
        $this->content[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return static
     */
    protected function setAttribute(string $name, mixed $value): static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function export(): array
    {
        return [
            'data' => $this->data,
            'content' => $this->content,
            'identifier' => $this->identifier,
            'attributes' => $this->attributes,
            'componentName' => $this->getComponentName(),
        ];
    }
}
