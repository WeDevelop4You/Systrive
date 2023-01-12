<?php

namespace Support\Client\Components\Navbar\Navigations\Items;

class NavigationContentItemComponent extends AbstractNavigationItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NavigationContentItemComponent';
    }

    /**
     * @param string $title
     *
     * @return NavigationContentItemComponent
     */
    public function setTitle(string $title): NavigationContentItemComponent
    {
        return $this->setContent('title', $title);
    }
}
