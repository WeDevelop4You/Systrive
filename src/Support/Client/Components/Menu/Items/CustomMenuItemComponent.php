<?php

namespace Support\Client\Components\Menu\Items;

use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Enums\Component\NavigationCustomItemType;

class CustomMenuItemComponent extends AbstractMenuItemComponent
{
    /**
     * @param string $title
     *
     * @return CustomMenuItemComponent
     */
    public function setTitle(string $title): CustomMenuItemComponent
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param IconComponent|ImageComponent $component
     *
     * @return CustomMenuItemComponent
     */
    public function setPrepend(IconComponent|ImageComponent $component): CustomMenuItemComponent
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param NavigationCustomItemType $type
     *
     * @return CustomMenuItemComponent
     */
    public function setType(NavigationCustomItemType $type): CustomMenuItemComponent
    {
        return $this->setData('type', $type->value);
    }
}
