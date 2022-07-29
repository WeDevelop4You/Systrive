<?php

namespace Support\Response\Components\Buttons;

use Support\Enums\Component\Vuetify\VuetifyColors;
use Support\Response\Components\Icons\IconComponent;

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
        return 'IconBtn';
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
     * @param VuetifyColors $color
     *
     * @return IconButtonComponent
     */
    public function setColorOnHover(VuetifyColors $color): IconButtonComponent
    {
        return $this->setData('hoverColor', $color->value);
    }
}
