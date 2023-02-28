<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;
use Support\Client\Traits\ComponentWithClasses;

class LabelComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'LabelComponent';
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setLabel(mixed $value): static
    {
        return $this->setContent('label', $value);
    }
}
