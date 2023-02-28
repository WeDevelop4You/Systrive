<?php

namespace Domain\Cms\Columns\Options\FIle\Dimensions;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Rules\DimensionRule;
use Illuminate\Foundation\Http\FormRequest;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\Custom\CustomDimensionInputComponentType;
use Support\Utils\Validations;

class HeightDimensionColumnOption extends AbstractColumnOption
{
    protected function col(): int
    {
        return 6;
    }

    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'dimension_height';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return CustomDimensionInputComponentType::create()
            ->setLabel(trans('word.height.height'));
    }

    /**
     * {@inheritDoc}
     */
    protected function requirements(FormRequest $request): Validations
    {
        return new Validations([
            "required_unless:{$this->getOtherFormKey('dimension_width')},null",
            'nullable',
            'integer',
            'min:1',
            new DimensionRule(
                $this->getOtherFormKey('dimension_width'),
                $this->getOtherFormKey('aspect_ratio_width'),
                $this->getOtherFormKey('aspect_ratio_height'),
            ),
        ]);
    }
}
