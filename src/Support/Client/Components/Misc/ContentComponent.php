<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;
use Support\Client\Traits\ComponentWithClasses;

class ContentComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'ContentComponent';
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        return $this->setContent('value', $value);
    }
}
