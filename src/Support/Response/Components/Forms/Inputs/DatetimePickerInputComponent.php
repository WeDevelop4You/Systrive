<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\Forms\Attributes\InputComponentWithDate;
use Support\Response\Components\Forms\Attributes\InputComponentWithTime;

class DatetimePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithTime, InputComponentWithDate;

    protected function __construct()
    {
        parent::__construct();

        $this->setDateFormat('dd-MM-yyyy')
            ->setUseSeconds(false)
            ->setReadonly();
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'DatetimePickerInputComponent';
    }
}
