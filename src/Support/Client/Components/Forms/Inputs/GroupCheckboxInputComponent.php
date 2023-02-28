<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Utils\ColOptionsComponent;

class GroupCheckboxInputComponent extends AbstractInputComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'GroupCheckboxInputComponent';
    }

    /**
     * @param ColOptionsComponent $colOptions
     *
     * @return $this
     */
    public function setColOptions(ColOptionsComponent $colOptions): static
    {
        return $this->setData('col', $colOptions->export());
    }
}
