<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Forms\Attributes\InputComponentWithDate;
use Support\Client\Components\Forms\Attributes\InputComponentWithTime;

class DatetimePickerInputComponent extends AbstractInputComponent
{
    use InputComponentWithTime;
    use InputComponentWithDate;

    protected function __construct()
    {
        parent::__construct();

        $this->setDateFormat('dd-MM-yyyy')
            ->setUseSeconds(false);
    }

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'DatetimePickerInputComponent';
    }
}
