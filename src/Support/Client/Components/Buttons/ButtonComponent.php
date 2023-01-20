<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Components\Misc\Icons\IconWithTextComponent;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\Vuetify\VuetifyButtonType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class ButtonComponent extends AbstractButtonComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'BtnComponent';
    }

    /**
     * @param string $title
     *
     * @return ButtonComponent
     */
    public function setTitle(string $title): ButtonComponent
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param IconWithTextComponent $component
     *
     * @return ButtonComponent
     */
    public function setTitleWithIcon(IconWithTextComponent $component): ButtonComponent
    {
        return $this->setdata('component', $component->export());
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return ButtonComponent
     */
    public function setColor(VuetifyColor|ThemeComponent $color = VuetifyColor::PRIMARY): ButtonComponent
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @param VuetifyButtonType $type
     *
     * @return ButtonComponent
     */
    public function setType(VuetifyButtonType $type = VuetifyButtonType::TEXT): ButtonComponent
    {
        return $this->setAttribute($type->value, true);
    }
}
