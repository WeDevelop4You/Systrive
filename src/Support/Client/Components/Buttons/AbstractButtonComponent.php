<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Actions\Action;
use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Enums\Component\TargetType;
use Support\Enums\Component\Vuetify\VuetifySizeType;

abstract class AbstractButtonComponent extends Component
{
    use ComponentWithClasses;

    /**
     * @param VuetifySizeType $size
     *
     * @return static
     */
    public function setSize(VuetifySizeType $size = VuetifySizeType::SMALL): static
    {
        return $this->setAttribute($size->value, true);
    }

    /**
     * @param string     $route
     * @param TargetType $target
     *
     * @return static
     */
    public function setHref(string $route, TargetType $target = TargetType::BLANK): static
    {
        return $this->setAttribute('href', $route)
            ->setAttribute('target', $target->value);
    }

    /**
     * @param Action $action
     *
     * @return static
     */
    public function setAction(Action $action): static
    {
        return $this->setData('action', $action->export());
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
