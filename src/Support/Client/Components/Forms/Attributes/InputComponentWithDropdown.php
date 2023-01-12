<?php

namespace Support\Client\Components\Forms\Attributes;

use Support\Client\Components\Forms\Utils\KeyValueObject;

trait InputComponentWithDropdown
{
    /**
     * @param bool $condition
     *
     * @return static
     */
    public function setReturnObject(bool $condition = true): static
    {
        return $this->setAttribute('return-object', $condition);
    }

    /**
     * @param array $items
     *
     * @return static
     */
    public function setItems(array $items): static
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @param mixed $item
     *
     * @return static
     */
    public function addItem(mixed $item): static
    {
        if ($item instanceof KeyValueObject) {
            $item = $item->export();
        }

        return $this->setData('items', $item, true);
    }
}
