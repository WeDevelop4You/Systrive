<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\Forms\Attributes\InputComponentWithTime;

class TimePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithTime;

    protected function __construct()
    {
        parent::__construct();

        $this->setUseSeconds(false)
            ->setReadonly();
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'TimePickerInputComponent';
    }
}
