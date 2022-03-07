<?php

namespace Support\Helpers\Details\Items;

use Support\Abstracts\AbstractListItem;

class ListItemActive extends AbstractListItem
{
    protected function getType(): string
    {
        return 'Active';
    }

    public function setValue(mixed $value): static
    {
        if (in_array($value, ['yes', 'enabled'])) {
            $value = [
                'is_active' => true,
                'content' => trans('word.active.active'),
            ];
        } else {
            $value = [
                'is_active' => false,
                'content' => trans('word.inactive.inactive'),
            ];
        }

        return parent::setValue($value);
    }
}
