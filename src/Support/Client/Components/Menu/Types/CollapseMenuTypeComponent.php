<?php

namespace Support\Client\Components\Menu\Types;

use Support\Client\Components\Misc\IconComponent;

class CollapseMenuTypeComponent extends AbstractMenuTypeComponent
{
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
     * @return CollapseMenuTypeComponent
     */
    public function setIcon(IconComponent $icon): CollapseMenuTypeComponent
    {
        return $this->setData('icon', $icon->export());
    }
}
