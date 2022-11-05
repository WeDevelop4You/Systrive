<?php

namespace Support\Response\Components\Icons;

use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Utils\ThemeComponent;

abstract class AbstractIconComponent extends AbstractComponent
{
    /**
     * @param IconType $icon
     *
     * @return IconComponent
     */
    public function setType(IconType $icon): static
    {
        return $this->setContent('type', $icon->value);
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return $this
     */
    public function setColor(VuetifyColor|ThemeComponent $color): static
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setAttribute('color', $value);
    }
}
