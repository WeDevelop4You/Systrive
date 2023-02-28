<?php

namespace Support\Client\Components\Menu;

use Support\Client\Components\Component;
use Support\Client\Components\Menu\Types\AbstractMenuTypeComponent;

class MenuComponent extends Component
{
    /**
     * @param string $title
     *
     * @return MenuComponent
     */
    public function addSubheader(string $title): MenuComponent
    {
        return $this->setData('items', ['subheader' => $title], true);
    }

    /**
     * @return MenuComponent
     */
    public function addDivider(): MenuComponent
    {
        return $this->setData('items', ['divider' => true], true);
    }

    /**
     * @param AbstractMenuTypeComponent[]|array $items
     *
     * @return MenuComponent
     */
    public function addTypes(array $items): MenuComponent
    {
        foreach ($items as $item) {
            if ($item instanceof AbstractMenuTypeComponent) {
                $this->addType($item);
            }
        }

        return $this;
    }

    /**
     * @param AbstractMenuTypeComponent $item
     *
     * @return MenuComponent
     */
    public function addType(AbstractMenuTypeComponent $item): MenuComponent
    {
        return $this->setData('items', $item->export(), true);
    }

    /**
     * @return MenuComponent
     */
    public function setShaped(): MenuComponent
    {
        return $this->setAttribute('shaped', true);
    }

    /**
     * @return MenuComponent
     */
    public function setNav(): MenuComponent
    {
        return $this->setAttribute('nav', true);
    }
}
