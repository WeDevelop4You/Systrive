<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

class NavigationCustomItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NavigationCustomItem';
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
