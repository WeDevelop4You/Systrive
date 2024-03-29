<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Types\ArgumentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Utils\Validations;

class TotalColumnOption extends AbstractColumnOption implements ArgumentColumnOption
{
    public function __construct(
        private readonly array $requirements,
        private readonly ?int $default = 8
    ) {
        //
    }

    protected function col(): int
    {
        return 6;
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'total';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): ?int
    {
        return $this->default;
    }

    /**
     * {@inheritDoc}
     */
    public function getArgumentKey(): string
    {
        return 'total';
    }

    /**
     * {@inheritDoc}
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setLabel(trans('word.total.numbers'))
            ->setDefaultValue($this->defaultValue());
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', ...$this->requirements]);
    }
}
