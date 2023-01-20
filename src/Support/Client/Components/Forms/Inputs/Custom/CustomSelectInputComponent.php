<?php

namespace Support\Client\Components\Forms\Inputs\Custom;

use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Enums\Component\Form\FormSelectInputType;

class CustomSelectInputComponent extends SelectInputComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'CustomInputComponent';
    }

    /**
     * @param FormSelectInputType $inputType
     *
     * @return CustomSelectInputComponent
     */
    public function setType(FormSelectInputType $inputType): CustomSelectInputComponent
    {
        return $this->setData('type', $inputType->value);
    }
}
