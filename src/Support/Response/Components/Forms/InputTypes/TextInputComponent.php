<?php

namespace Support\Response\Components\Forms\InputTypes;

class TextInputComponent extends AbstractInputComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'TextInput';
    }
}
