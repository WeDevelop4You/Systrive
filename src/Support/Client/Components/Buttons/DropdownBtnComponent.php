<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Components\Component;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Definitions\WrapperComponentType;
use Support\Enums\Component\Vuetify\VuetifyTransitionType;

class DropdownBtnComponent extends Component implements WrapperComponentType
{
    /**
     * @return $this
     */
    public function setBottom(): static
    {
        return $this->setAttribute('bottom', true);
    }

    /**
     * @return $this
     */
    public function setOffsetY(): static
    {
        return $this->setAttribute('offset-y', true);
    }

    /**
     * @param VuetifyTransitionType $transition
     *
     * @return $this
     */
    public function setTransition(VuetifyTransitionType $transition): static
    {
        return $this->setAttribute('transition', $transition->value);
    }

    /**
     * @param AbstractBtnComponent $button
     *
     * @return $this
     */
    public function setButton(AbstractBtnComponent $button): static
    {
        return $this->setData('button', $button->export());
    }

    /**
     * @param MenuComponent $menu
     *
     * @return $this
     */
    public function setMenu(MenuComponent $menu): static
    {
        return $this->setData('menu', $menu->export());
    }
}
