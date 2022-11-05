<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\AbstractComponent;

class ConditionInputComponent extends AbstractComponent
{
    /**
     * @inheritDoc
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
     * @param string $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setData('vuexNamespace', $vuexNamespace);
    }
}
