<?php

namespace Domain\Cms\Columns\Options;

use Domain\Cms\Columns\Options\Types\ArgumentDirtyColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Utils\Validations;

class PlacesColumnOption extends AbstractColumnOption implements ArgumentDirtyColumnOption
{
    public function __construct(
        private readonly array $requirements,
        private readonly ?int $default = 2
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
        return 'places';
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
        return 'places';
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
            ->setLabel(trans('word.total.after.dot'))
            ->setDefaultValue($this->defaultValue());
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        $totalKey = $this->getOtherFormKey('total');

        return new Validations(['nullable', "lt:{$totalKey}", ...$this->requirements]);
    }
}
