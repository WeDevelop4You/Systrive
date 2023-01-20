<?php

namespace Support\Client\Components\Forms\Inputs;

class TextareaInputComponent extends AbstractInputComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'TextareaInputComponent';
    }

    /**
     * @return $this
     */
    public function setAutoGrow(): static
    {
        return $this->setAttribute('auto-grow', true);
    }
}
