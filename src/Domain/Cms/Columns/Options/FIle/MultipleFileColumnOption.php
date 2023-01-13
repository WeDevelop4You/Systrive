<?php

namespace Domain\Cms\Columns\Options\FIle;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Utils\Validations;

class MultipleFileColumnOption extends AbstractColumnOption implements ComponentColumnOption
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'multiple';
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
        return CheckboxInputComponent::create()->setLabel('word.multiple.files');
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['boolean', 'nullable']);
    }
}
