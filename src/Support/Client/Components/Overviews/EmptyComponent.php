<?php

namespace Support\Client\Components\Overviews;

use Support\Client\Components\Component;

class EmptyComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'EmptyComponent';
    }
}
