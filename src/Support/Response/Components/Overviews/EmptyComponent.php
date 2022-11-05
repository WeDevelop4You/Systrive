<?php

namespace Support\Response\Components\Overviews;

use Support\Response\Components\AbstractComponent;

class EmptyComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'EmptyComponent';
    }
}
