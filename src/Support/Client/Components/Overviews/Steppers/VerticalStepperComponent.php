<?php

namespace Support\Client\Components\Overviews\Steppers;

use Support\Client\Components\Types\ModalComponentType;

class VerticalStepperComponent extends AbstractStepperComponent implements ModalComponentType
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'VerticalStepperComponent';
    }
}
