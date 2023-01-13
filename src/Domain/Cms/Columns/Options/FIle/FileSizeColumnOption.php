<?php

namespace Domain\Cms\Columns\Options\FIle;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Columns\Options\Types\ComponentColumnOption;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Utils\Validations;

class FileSizeColumnOption extends AbstractColumnOption implements ComponentColumnOption
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'size';
    }

    /**
     * @inheritDoc
     */
    protected function defaultValue(): int
    {
        return 5120;
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setDefaultValue($this->defaultValue())
            ->setLabel(trans('word.size.file') . ' (KB)');
    }

    /**
     * max file size 10MB.
     *
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['required', 'integer', 'between:1,10240']);
    }
}
