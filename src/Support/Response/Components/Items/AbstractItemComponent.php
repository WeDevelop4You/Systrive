<?php

namespace Support\Response\Components\Items;

use Support\Response\Components\AbstractComponent;
use Support\Traits\ComponentWithClasses;

abstract class AbstractItemComponent extends AbstractComponent
{
    use ComponentWithClasses;

    private bool $condition = true;

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): static
    {
        return $this->setContent('label', $label);
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

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setCondition(bool $condition): static
    {
        $this->condition = $condition;

        return  $this;
    }

    /**
     * @return bool
     */
    public function getCondition(): bool
    {
        return $this->condition;
    }
}
