<?php

namespace Support\Client\Components\Misc\Icons;

class IconWithTextComponent extends AbstractIconComponent
{
    /**
     * @return string
     */
    protected function getComponentName(): string
    {
        return 'IconWithTextComponent';
    }

    /**
     * @param string $text
     *
     * @return IconWithTextComponent
     */
    public function setText(string $text): IconWithTextComponent
    {
        return $this->setContent('text', $text);
    }

    /**
     * @return IconWithTextComponent
     */
    public function setLeftSide(): IconWithTextComponent
    {
        return $this->setData('side', 'left');
    }

    /**
     * @return IconWithTextComponent
     */
    public function setRightSide(): IconWithTextComponent
    {
        return $this->setData('side', 'right');
    }
}
