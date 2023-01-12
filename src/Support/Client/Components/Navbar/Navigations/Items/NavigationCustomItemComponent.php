<?php

namespace Support\Client\Components\Navbar\Navigations\Items;

use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Misc\ImageComponent;
use Support\Enums\Component\NavigationCustomItemType;

class NavigationCustomItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NavigationCustomItemComponent';
    }

    /**
     * @param string $title
     *
     * @return NavigationCustomItemComponent
     */
    public function setTitle(string $title): NavigationCustomItemComponent
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param IconComponent|ImageComponent $component
     *
     * @return NavigationCustomItemComponent
     */
    public function setPrepend(IconComponent|ImageComponent $component): NavigationCustomItemComponent
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param NavigationCustomItemType $type
     *
     * @return NavigationCustomItemComponent
     */
    public function setType(NavigationCustomItemType $type): NavigationCustomItemComponent
    {
        return $this->setData('type', $type->value);
    }
}
