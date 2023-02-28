<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class IconComponent extends Component
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

    /**
     * @return $this
     */
    public function setLeftSide(): static
    {
        return $this->setData('side', 'left');
    }

    /**
     * @return $this
     */
    public function setRightSide(): static
    {
        return $this->setData('side', 'right');
    }
}
