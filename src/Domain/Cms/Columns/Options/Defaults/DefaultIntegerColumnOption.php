<?php

namespace Domain\Cms\Columns\Options\Defaults;

use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Utils\Validations;

class DefaultIntegerColumnOption extends AbstractDefaultColumnOption
{
    /**
     * DefaultIntegerColumnOption constructor.
     *
     * @param array $requirements
     */
    public function __construct(
        private readonly array $requirements,
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()->setLabel(trans('word.default.value'));
    }

    /**
     * @inheritDoc
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations(['nullable', ...$this->requirements]);
    }
}
