<?php

namespace Support\Client\Components\Navbar\Navigations\Items;

use Support\Client\Components\Component;
use Support\Client\Components\Utils\TooltipComponent;

abstract class AbstractNavigationItemComponent extends Component
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
