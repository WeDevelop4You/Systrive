<?php

namespace Domain\Cms\Columns\Options;

use Support\Utils\Validations;
use Domain\Cms\Columns\Options\Types\ArgumentDirtyColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;

class TotalColumnOption extends AbstractColumnOption implements ArgumentDirtyColumnOption
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
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'total';
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): ?int
    {
        return $this->default;
    }

    /**
     * @inheritDoc
     */
    public function getArgumentKey(): string
    {
        return 'total';
    }

    /**
     * @inheritDoc
     */
    public function isDirty(mixed $value): bool
    {
        return $this->getValue() !== $value;
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setLabel(trans('word.total.numbers'))
            ->setDefaultValue($this->defaultValue());
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', ...$this->requirements]);
    }
}
