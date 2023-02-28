<?php

namespace Support\Client\Components\Forms\Inputs\Custom;

use Support\Client\Components\Forms\Inputs\NumberInputComponent;
use Support\Client\Definitions\CustomInputComponentType;
use Support\Enums\Component\Inputs\CustomInputType;

class CustomDimensionInputComponentType extends NumberInputComponent implements CustomInputComponentType
{
    /**
     * CustomDimensionInputComponent constructor
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setType();
    }

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'CustomInputComponent';
    }

    /**
     * {@inheritDoc}
     */
    public function setType(CustomInputType|null $inputType = null): static
    {
        return $this->setData('type', 'DimensionInputComponent');
    }
}
