<?php

namespace Support\Response\Components\Images;

use Support\Response\Components\AbstractComponent;

class ImageComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'ImageComponent';
    }

    /**
     * @param string $source
     *
     * @return ImageComponent
     */
    public function setSource(string $source): ImageComponent
    {
        return $this->setAttribute('src', $source);
    }

    /**
     * @param int $width
     *
     * @return ImageComponent
     */
    public function setMaxWidth(int $width): ImageComponent
    {
        return $this->setAttribute('max-width', $width);
    }

    /**
     * @param int $height
     *
     * @return ImageComponent
     */
    public function setMaxHeight(int $height): ImageComponent
    {
        return $this->setAttribute('max-height', $height);
    }

    /**
     * @param int $size
     *
     * @return ImageComponent
     */
    public function setSize(int $size): ImageComponent
    {
        return $this->setMaxWidth($size)->setMaxHeight($size);
    }
}
