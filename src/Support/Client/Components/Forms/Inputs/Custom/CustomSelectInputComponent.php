<?php

namespace Support\Client\Components\Forms\Inputs\Custom;

use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Types\CustomInputComponent;
use Support\Enums\Component\Inputs\CustomInputType;

class CustomSelectInputComponent extends SelectInputComponent implements CustomInputComponent
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
