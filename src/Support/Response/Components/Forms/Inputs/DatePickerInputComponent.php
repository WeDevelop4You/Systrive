<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\Forms\Attributes\InputComponentWithDate;

class DatePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithDate;

    protected function __construct()
    {
        parent::__construct();

        $this->setDateFormat('dd-MM-yyyy')
            ->setReadonly();
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'DatePickerInputComponent';
    }
}
