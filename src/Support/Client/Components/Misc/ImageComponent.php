<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;

class ImageComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'ImageComponent';
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource(string $source): static
    {
        return $this->setAttribute('src', $source);
    }

    /**
     * @param string $alt
     *
     * @return $this
     */
    public function setAlt(string $alt): static
    {
        return $this->setAttribute('alt', $alt);
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setMinWidth(int $width): static
    {
        return $this->setAttribute('min-width', $width);
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setMaxWidth(int $width): static
    {
        return $this->setAttribute('max-width', $width);
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setMinHeight(int $height): static
    {
        return $this->setAttribute('min-height', $height);
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setMaxHeight(int $height): static
    {
        return $this->setAttribute('max-height', $height);
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setSize(int $size): static
    {
        return $this->setMaxWidth($size)->setMaxHeight($size);
    }
}
