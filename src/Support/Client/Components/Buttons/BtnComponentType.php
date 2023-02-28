<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Components\Misc\StringComponent;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Client\Definitions\WrapperComponentType;
use Support\Enums\Component\Vuetify\VuetifyButtonType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class BtnComponentType extends AbstractBtnComponent
{
    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->content['title'] = StringComponent::create()->setText($title)->export();

        return $this;
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return $this
     */
    public function setColor(VuetifyColor|ThemeComponent $color = VuetifyColor::PRIMARY): static
    {
        $value = $color instanceof ThemeComponent ? $color->export() : $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @param VuetifyButtonType $type
     *
     * @return $this
     */
    public function setType(VuetifyButtonType $type = VuetifyButtonType::TEXT): static
    {
        return $this->setAttribute($type->value, true);
    }
}
