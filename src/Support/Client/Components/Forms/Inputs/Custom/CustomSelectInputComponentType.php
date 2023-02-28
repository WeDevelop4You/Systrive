<?php

namespace Support\Client\Components\Forms\Inputs\Custom;

use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Definitions\CustomInputComponentType;
use Support\Enums\Component\Inputs\CustomInputType;

class CustomSelectInputComponentType extends SelectInputComponent implements CustomInputComponentType
{
    /**
     * CustomSelectInputComponent constructor
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
     * @param CustomInputType|null $inputType
     *
     * @return $this
     */
    public function setType(CustomInputType|null $inputType = null): static
    {
        return $this->setData('type', 'SelectColumnInputComponent');
    }
}
