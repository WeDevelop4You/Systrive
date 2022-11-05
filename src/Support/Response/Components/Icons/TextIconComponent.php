<?php

namespace Support\Response\Components\Icons;

class TextIconComponent extends AbstractIconComponent
{
    /**
     * @return string
     */
    protected function getComponentName(): string
    {
        return 'TextIconComponent';
    }

    /**
     * @param string $text
     *
     * @return TextIconComponent
     */
    public function setText(string $text): TextIconComponent
    {
        return $this->setContent('text', $text);
    }

    /**
     * @return TextIconComponent
     */
    public function setLeftSide(): TextIconComponent
    {
        return $this->setData('side', 'left');
    }

    /**
     * @return TextIconComponent
     */
    public function setRightSide(): TextIconComponent
    {
        return $this->setData('side', 'right');
    }
}
