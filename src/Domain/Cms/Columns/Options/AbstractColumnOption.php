<?php

namespace Domain\Cms\Columns\Options;

use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Layouts\ColComponent;

abstract class AbstractColumnOption
{
    /**
     * @var mixed
     */
    private mixed $value;

    /**
     * @var string
     */
    private string $prefix;

    /**
     * @return mixed
     */
    final public function getValue(): mixed
    {
        return $this->value ?? $this->getDefault();
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    final public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    final public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    final public function getKey(): string
    {
        return "{$this->prefix}_{$this->getType()}";
    }

    /**
     * @return string
     */
    final public function getFormKey(): string
    {
        return "properties.{$this->getKey()}";
    }

    /**
     * @param string $type
     *
     * @return string
     */
    final protected function getOtherFormKey(string $type): string
    {
        return "properties.{$this->prefix}_{$type}";
    }

    /**
     * @return string
     */
    final protected function getVuexNameSpace(): string
    {
        return 'cms/table/columns/form';
    }

    /**
     * @return string
     */
    abstract protected function getType(): string;

    /**
     * @return mixed
     */
    abstract public function getDefault(): mixed;

    /**
     * @param bool $isEditing
     *
     * @return ColComponent
     */
    abstract public function getFormComponent(bool $isEditing): ColComponent;

    /**
     * validation for creating and editing columns properties.
     *
     * @param FormRequest $request
     *
     * @return array
     */
    abstract public function getRequirements(FormRequest $request): array;
}
