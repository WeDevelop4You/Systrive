<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\Forms\Attributes\InputComponentWithCounter;

class TextInputComponent extends AbstractInputComponent
{
    use InputComponentWithCounter;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'TextInputComponent';
    }
}
