<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Actions\Action;
use Support\Client\Components\Component;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\Definitions\WrapperComponentType;
use Support\Client\Traits\ComponentWithClasses;
use Support\Enums\Component\TargetType;
use Support\Enums\Component\Vuetify\VuetifySizeType;

abstract class AbstractBtnComponent extends Component implements WrapperComponentType
{
    use ComponentWithClasses;

    protected array $content = [];

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'BtnComponent';
    }

    /**
     * @param IconComponent $icon
     *
     * @return $this
     */
    public function setIcon(IconComponent $icon): static
    {
        $this->content['icon'] = $icon->export();

        return $this;
    }

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

    /**
     * @return array
     */
    public function export(): array
    {
        $this->setdata('content', array_values($this->content));

        return parent::export();
    }
}
