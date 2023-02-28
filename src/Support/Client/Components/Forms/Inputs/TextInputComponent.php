<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Forms\Attributes\InputComponentWithCounter;

class TextInputComponent extends AbstractInputComponent
{
    use InputComponentWithCounter;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'TextInputComponent';
    }

    /**
     * @return $this
     */
    public function setAppendOuter(): static
    {
        return $this;
    }
}
