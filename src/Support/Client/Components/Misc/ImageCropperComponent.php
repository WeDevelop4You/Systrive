<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;

class ImageCropperComponent extends Component
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'ImageCropperComponent';
    }

    /**
     * @param string $vuexNamespace
     *
     * @return $this
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setData('vuexNamespace', $vuexNamespace);
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return $this
     */
    public function setAspectRatio(int $width, int $height): static
    {
        return $this->setData('aspectRatio', $width / $height);
    }
}
