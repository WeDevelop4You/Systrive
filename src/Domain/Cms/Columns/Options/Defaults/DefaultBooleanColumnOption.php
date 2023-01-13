<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Utils\Validations;

class DefaultBooleanColumnOption extends AbstractDefaultColumnOption
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return CheckboxInputComponent::create()->setLabel(trans('word.default.use.current'));
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', 'boolean']);
    }
}
