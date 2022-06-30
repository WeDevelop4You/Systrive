<?php

namespace Support\Response\Components\Items;

use Support\Response\Components\AbstractComponent;
use Support\Traits\ComponentWithClasses;

abstract class AbstractItemComponent extends AbstractComponent
{
    use ComponentWithClasses;

    /**
     * @param string $label
     *
     * @return static
     */
    public function setLabel(string $label): static
    {
        return $this->setContent('label', $label);
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setValue(mixed $value): static
    {
        return $this->setContent('value', $value);
    }
}
