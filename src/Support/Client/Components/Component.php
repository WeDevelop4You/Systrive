<?php

namespace Support\Client\Components;

use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

abstract class Component
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
     * @return UuidInterface
     */
    public function getIdentifier(): UuidInterface
    {
        return $this->identifier;
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return array
     */
    protected function getData(string $key, mixed $default = null): array
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param bool   $isArray
     *
     * @return static
     */
    protected function setData(string $key, mixed $value, bool $isArray = false): static
    {
        $isArray ? $this->data[$key][] = $value : $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return array
     */
    protected function getContent(string $key, mixed $default = null): array
    {
        return $this->content[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    protected function setContent(string $key, mixed $value): static
    {
        $this->content[$key] = $value;

        return $this;
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return array
     */
    protected function getAttribute(string $key, mixed $default = null): array
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    protected function setAttribute(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

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

    /**
     * @return string
     */
    abstract protected function getComponentName(): string;
}
