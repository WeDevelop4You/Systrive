<?php

namespace Support\Client\Components\Menu\Items;

use Support\Client\Components\Component;
use Support\Client\Components\Utils\TooltipComponent;

abstract class AbstractMenuItemComponent extends Component
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
