<?php

namespace Support\Client\Components\Navbar\Navigations;

use Support\Client\Components\Misc\Icons\IconComponent;

class CollapseNavigationComponent extends AbstractNavigationComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'CollapseNavigationComponent';
    }

    /**
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param IconComponent $icon
     *
     * @return CollapseNavigationComponent
     */
    public function setIcon(IconComponent $icon): CollapseNavigationComponent
    {
        return $this->setData('icon', $icon->export());
    }
}
