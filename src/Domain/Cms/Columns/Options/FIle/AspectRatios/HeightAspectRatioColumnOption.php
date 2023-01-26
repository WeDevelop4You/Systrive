<?php

namespace Domain\Cms\Columns\Options\FIle\AspectRatios;

use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\NumberInputComponent;

class HeightAspectRatioColumnOption extends AbstractAspectRatio
{
    /**
     * {@inheritDoc}
     */
    protected function type(): string
    {
        return 'aspect_ratio_height';
    }

    /**
     * {@inheritDoc}
     */
    protected function defaultValue(): int
    {
        return 9;
    }

    /**
     * {@inheritDoc}
     */
    protected function inputComponent(bool $isEditing): AbstractInputComponent
    {
        return NumberInputComponent::create()
            ->setLabel(trans('word.height.height'));
    }
}
