<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Utils\Validations;


class DefaultStringColumnOption extends AbstractDefaultColumnOption
{
    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return TextInputComponent::create()->setLabel(trans('word.default.value'));
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', 'string']);
    }
}
