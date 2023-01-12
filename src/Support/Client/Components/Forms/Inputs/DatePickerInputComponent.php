<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Forms\Attributes\InputComponentWithDate;

class DatePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithDate;

    protected function __construct()
    {
        parent::__construct();

        $this->setDateFormat('dd-MM-yyyy');
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'DatePickerInputComponent';
    }
}
