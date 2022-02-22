<?php

namespace Support\Helpers\Details\Items;

use Support\Abstracts\AbstractListItem;

class ListItemBadges extends AbstractListItem
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'Badges';
    }

    public function setValue(mixed $value): static
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        parent::setValue($value);

        return $this;
    }
}
