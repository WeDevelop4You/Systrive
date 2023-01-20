<?php

namespace Domain\Cms\Columns\Options\FIle;

use Domain\Cms\Columns\Attributes\AdditionalValidation;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Utils\Validations;

abstract class AbstractExtension extends AbstractColumnOption implements ComponentColumnOption, AdditionalValidation
{
    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'types';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return SelectInputComponent::create()
            ->setChips()
            ->setMultiple()
            ->setSmallChips()
            ->setDeletableChips()
            ->setItems($this->getItems())
            ->setDefaultValue($this->defaultValue())
            ->setLabel(trans('word.allowed.extensions'));
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(
            ['required', 'array'],
            ['*' => new Validations([Rule::in($this->extensions())])]
        );
    }

    /**
     * @return array
     */
    private function getItems(): array
    {
        return Collection::make($this->extensions())->sort()->map(
            fn (string $extension) => KeyValueObject::create()->setValue($extension)->setText($extension)
        )->toArray();
    }

    /**
     * @return array
     */
    abstract protected function extensions(): array;
}
