<?php

namespace Support\Client\Components\Layouts;

use Support\Client\Components\Component;
use Support\Client\Definitions\WrapperComponentType;
use Support\Client\Traits\ComponentWithClasses;
use Support\Client\Traits\ComponentWithIfStatement;

/**
 * @method $this addComponentIf(bool $condition, WrapperComponentType $component)
 */
class WrapperComponent extends Component
{
    use ComponentWithClasses;
    use ComponentWithIfStatement;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'WrapperComponent';
    }

    /**
     * @param array $components
     *
     * @return $this
     */
    public function setComponents(array $components): WrapperComponent
    {
        foreach ($components as $component) {
            if ($component instanceof WrapperComponentType) {
                $this->addComponent($component);
            }
        }

        return $this;
    }

    public function addComponent(WrapperComponentType $component): WrapperComponent
    {
        return $this->setData('items', $component->export(), true);
    }
}
