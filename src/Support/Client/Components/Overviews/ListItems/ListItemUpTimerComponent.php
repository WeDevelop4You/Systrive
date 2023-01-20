<?php

namespace Support\Client\Components\Overviews\ListItems;

use Support\Client\Components\Attributes\ComponentAsListItem;
use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;

class ListItemUpTimerComponent extends Component implements ListItemComponent
{
    use ComponentAsListItem;
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'UpTimerComponent';
    }
}
