<?php

namespace Domain\Cms\Columns\Options;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Utils\Validations;

abstract class AbstractColumnOption
{
    /**
     * @var Collection
     */
    private Collection $properties;

    /**
     * @var string
     */
    private string $prefix;

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
     * @param Collection $values
     *
     * @return $this
     */
    final public function setProperties(Collection $values): static
    {
        $this->properties = $values;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    protected function getProperties(string $key, mixed $default = null): mixed
    {
        return $this->properties->get($key, $default);
    }

    /**
     * @return string
     */
    final public function getKey(): string
    {
        return "{$this->prefix}_{$this->type()}";
    }

    /**
     * @return mixed
     */
    final public function getValue(): mixed
    {
        return $this->getProperties(
            $this->getKey(),
            $this->defaultValue()
        );
    }

    /**
     * @return mixed
     */
    final public function getDefault(): mixed
    {
        return $this->defaultValue();
    }

    /**
     * @param bool $isEditing
     *
     * @return ColComponent
     */
    final public function getInputComponent(bool $isEditing): ColComponent
    {
        return ColComponent::create()
            ->setMdCol($this->col())
            ->setComponent(
                $this->inputComponent($isEditing)
                    ->setKey($this->getFormKey())
                    ->setVuexNamespace('cms/table/columns/form')
            );
    }

    /**
     * @param FormRequest $request
     *
     * @return array
     */
    final public function getRequirements(FormRequest $request): array
    {
        return $this->requirements($request)->toArray($this->getFormKey());
    }

    /**
     * @return int
     */
    protected function col(): int
    {
        return 12;
    }

    /**
     * @return string
     */
    final protected function getFormKey(): string
    {
        return "properties.{$this->getKey()}";
    }

    /**
     * @param string $type
     *
     * @return string
     */
    final protected function getOtherKey(string $type): string
    {
        return "{$this->prefix}_{$type}";
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
    abstract protected function type(): string;

    /**
     * @return mixed
     */
    abstract protected function defaultValue(): mixed;

    /**
     * @param bool $isEditing
     *
     * @return AbstractInputComponent
     */
    abstract protected function inputComponent(bool $isEditing): AbstractInputComponent;

    /**
     * validation for creating and editing columns properties.
     *
     * @param FormRequest $request
     *
     * @return Validations
     */
    abstract protected function requirements(FormRequest $request): Validations;
}
