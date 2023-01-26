<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;

class HintComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'HintComponent';
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setHint(mixed $value): static
    {
        return $this->setContent('hint', $value);
    }
}
