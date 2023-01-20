<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Component;
use Support\Utils\VuexNamespace;

class ConditionInputComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'ConditionInputComponent';
    }

    public function setPath(string $path): static
    {
        return $this->setData('path', $path);
    }

    /**
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string|VuexNamespace $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
    }
}
