<?php

namespace Domain\Cms\Columns\Options\FIle;

class ImageExtensionColumnOption extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    protected function extensions(): array
    {
        return [
            'png',
            'jpg',
            'jpeg',
            'gif',
        ];
    }
}
