<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Images\ImageComponent;
use Support\Response\Components\Utils\TooltipComponent;

abstract class AbstractNavigationItemComponent extends AbstractComponent
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
     * @param IconComponent|ImageComponent $component
     *
     * @return static
     */
    public function setPrepend(IconComponent|ImageComponent $component): static
    {
        return $this->setData('prepend', $component->export());
    }

    /**
     * @param TooltipComponent $tooltip
     *
     * @return static
     */
    public function setTooltip(TooltipComponent $tooltip): static
    {
        return $this->setData('tooltip', $tooltip->export());
    }
}
