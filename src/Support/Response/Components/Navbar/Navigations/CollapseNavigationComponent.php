<?php

namespace Support\Response\Components\Navbar\Navigations;

use Support\Response\Components\Icons\IconComponent;

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
