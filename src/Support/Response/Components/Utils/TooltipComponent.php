<?php

namespace Support\Response\Components\Utils;

use Support\Response\Components\AbstractComponent;

class TooltipComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Tooltip';
    }

    /**
     * @param string $text
     *
     * @return TooltipComponent
     */
    public function setText(string $text): TooltipComponent
    {
        return $this->setContent('text', $text);
    }

    public function setOpenDelay(int $delay): TooltipComponent
    {
        return $this->setAttribute('open-delay', $delay);
    }

    /**
     * @return TooltipComponent
     */
    public function setTop(): TooltipComponent
    {
        return $this->setAttribute('top', true);
    }

    /**
     * @return TooltipComponent
     */
    public function setRight(): TooltipComponent
    {
        return $this->setAttribute('right', true);
    }

    /**
     * @return TooltipComponent
     */
    public function setBottom(): TooltipComponent
    {
        return $this->setAttribute('bottom', true);
    }

    /**
     * @return TooltipComponent
     */
    public function setLeft(): TooltipComponent
    {
        return $this->setAttribute('left', true);
    }
}
