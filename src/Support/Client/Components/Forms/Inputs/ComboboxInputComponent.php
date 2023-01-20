<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Forms\Attributes\InputComponentWithCounter;
use Support\Client\Components\Forms\Attributes\InputComponentWithDropdown;

class ComboboxInputComponent extends AbstractInputComponent
{
    use InputComponentWithDropdown;
    use InputComponentWithCounter;

    protected function __construct()
    {
        parent::__construct();

        $this->setReturnObject();
    }

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'ComboboxInputComponent';
    }
}
