<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Attributes\Validation;
use Domain\Cms\Columns\Options\Types\ArgumentDirtyColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Utils\Validations;

class MaxLengthColumnOption extends AbstractColumnOption implements ArgumentDirtyColumnOption, Validation
{
    public function __construct(
        private readonly int $default
    ) {
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'max_length';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): int
    {
        return $this->default;
    }

    /**
     * {@inheritDoc}
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * @return string
     */
    public function getArgumentKey(): string
    {
        return 'length';
    }

    /**
     * {@inheritDoc}
     */
    public function getValidation(FormRequest $request): Validations
    {
        return new Validations(["max:{$this->getValue()}"]);
    }

    /**
     * @param bool $isEditing *
     *
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setDefaultValue($this->defaultValue())
            ->setLabel(trans('word.max.length'));
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['required', 'integer', "between:1,{$this->default}"]);
    }
}
