<?php

namespace Support\Helpers\Details\Items;

use Support\Abstracts\AbstractListItem;

class ListItemText extends AbstractListItem
{
    protected function getType(): string
    {
        return 'Text';
    }
}
