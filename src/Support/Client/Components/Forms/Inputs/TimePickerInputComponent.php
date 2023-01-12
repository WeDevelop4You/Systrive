<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Forms\Attributes\InputComponentWithTime;

class TimePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithTime;

    protected function __construct()
    {
        parent::__construct();

        $this->setUseSeconds(false);
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'TimePickerInputComponent';
    }
}
