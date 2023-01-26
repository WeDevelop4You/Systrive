<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Enums\Component\Vuetify\VuetifyColor;

class IconButtonComponent extends AbstractButtonComponent
{
    /**
     * IconButtonComponent constructor.
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setAttribute('icon', true);
    }

    /**
     * @return string
     */
    protected function getComponentName(): string
    {
        return 'IconBtnComponent';
    }

    /**
     * @param IconComponent $icon
     *
     * @return IconButtonComponent
     */
    public function setIcon(IconComponent $icon): IconButtonComponent
    {
        return $this->setData('icon', $icon->export());
    }

    /**
     * @param VuetifyColor $color
     *
     * @return IconButtonComponent
     */
    public function setColorOnHover(VuetifyColor $color): IconButtonComponent
    {
        return $this->setData('hoverColor', $color->value);
    }
}