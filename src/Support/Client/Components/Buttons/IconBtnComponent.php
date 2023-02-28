<?php

namespace Support\Client\Components\Buttons;

use Support\Enums\Component\Vuetify\VuetifyColor;

class IconBtnComponent extends AbstractBtnComponent
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
     * @param VuetifyColor $color
     *
     * @return $this
     */
    public function setColorOnHover(VuetifyColor $color): static
    {
        return $this->setData('hoverColor', $color->value);
    }
}
