<?php

namespace Support\Response\Components\Navbar\Navigations\Items;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Utils\TooltipComponent;

abstract class AbstractNavigationItemComponent extends AbstractComponent
{
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
