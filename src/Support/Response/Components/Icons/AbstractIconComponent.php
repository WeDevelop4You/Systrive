<?php

namespace Support\Response\Components\Icons;

use Support\Enums\IconTypes;
use Support\Response\Components\AbstractComponent;

abstract class AbstractIconComponent extends AbstractComponent
{
    /**
     * @param IconTypes $icon
     *
     * @return IconComponent
     */
    public function setType(IconTypes $icon): static
    {
        return $this->setContent('type', $icon->value);
    }
}
