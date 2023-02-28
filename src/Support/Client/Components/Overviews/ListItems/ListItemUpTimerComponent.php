<?php

namespace Support\Client\Components\Overviews\ListItems;

use Support\Client\Components\Component;
use Support\Client\Traits\ComponentAsListItem;
use Support\Client\Traits\ComponentWithClasses;

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
