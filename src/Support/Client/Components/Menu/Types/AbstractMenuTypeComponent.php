<?php

namespace Support\Client\Components\Menu\Types;

use Support\Client\Components\Component;
use Support\Client\Components\Menu\Items\AbstractMenuItemComponent;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Traits\ComponentWithIfStatement;

/**
 * @method $this addItemIf(bool $condition, MenuItemComponent $navigation)
 */
abstract class AbstractMenuTypeComponent extends Component
{
    use ComponentWithIfStatement;

    /**
     * @param AbstractMenuItemComponent[]|array $items
     *
     * @return static
     */
    public function addItems(array $items): static
    {
        foreach ($items as $item) {
            if ($item instanceof AbstractMenuItemComponent) {
                $this->addItem($item);
            }
        }

        return $this;
    }

    /**
     * @param AbstractMenuItemComponent $item
     *
     * @return static
     */
    public function addItem(AbstractMenuItemComponent $item): static
    {
        return $this->setData('items', $item->export(), true);
    }
}
