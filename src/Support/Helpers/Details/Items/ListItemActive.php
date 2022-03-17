<?php

namespace Support\Helpers\Details\Items;

use Support\Abstracts\AbstractListItem;
use Support\Helpers\Vesta\VestaHelper;

class ListItemActive extends AbstractListItem
{
    protected function getType(): string
    {
        return 'Active';
    }

    public function setValue(mixed $value, bool $reversed = false): static
    {
        $value = VestaHelper::isActive($value, $reversed);

        return parent::setValue($value);
    }
}
