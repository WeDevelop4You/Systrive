<?php

namespace Support\Response\Components\Forms\Inputs\Custom;

use Support\Enums\Component\Form\FormSelectInputType;
use Support\Response\Components\Forms\Inputs\SelectInputComponent;

class CustomSelectInputComponent extends SelectInputComponent
{
    /**
     * @inheritDoc
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
        return $this->setData('type', $inputType);
    }
}
