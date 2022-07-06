<?php

namespace Support\Response\Components\Buttons;

use Support\Enums\Vuetify\VuetifySizeTypes;
use Support\Response\Actions\AbstractAction;
use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Utils\TooltipComponent;
use Support\Traits\ComponentWithClasses;

abstract class AbstractButtonComponent extends AbstractComponent
{
    use ComponentWithClasses;

    protected function __construct()
    {
        parent::__construct();

        $this->setDefault(false);
    }

    /**
     * @param VuetifySizeTypes $size
     *
     * @return static
     */
    public function setSize(VuetifySizeTypes $size = VuetifySizeTypes::SMALL): static
    {
        return $this->setAttribute($size->value, true);
    }

    /**
     * @param string $href
     *
     * @return static
     */
    public function setHref(string $href): static
    {
        return $this->setAttribute('href', $href);
    }

    public function setTarget(string $target): static
    {
        return $this->setAttribute('target', "_{$target}");
    }

    /**
     * @param AbstractAction $action
     *
     * @return static
     */
    public function setAction(AbstractAction $action): static
    {
        return $this->setData('action', $action->export());
    }

    /**
     * @return $this
     */
    public function setDefault($value = true): static
    {
        return $this->setData('isDefault', $value);
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
