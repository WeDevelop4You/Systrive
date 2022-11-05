<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Images\ImageComponent;

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
     * @param string $type
     *
     * @return NavigationCustomItemComponent
     */
    public function setType(string $type): NavigationCustomItemComponent
    {
        return $this->setData('type', $type);
    }
}
