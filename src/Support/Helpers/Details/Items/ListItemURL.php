<?php

namespace Support\Helpers\Details\Items;

use Support\Abstracts\AbstractListItem;

class ListItemURL extends AbstractListItem
{
    protected function getType(): string
    {
        return 'URL';
    }

    public function setValue(mixed $value): static
    {
        $value = prep_url($value);

        return parent::setValue($value);
    }
}
