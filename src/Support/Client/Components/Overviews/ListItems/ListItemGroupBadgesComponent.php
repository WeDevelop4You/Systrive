<?php

namespace Support\Client\Components\Overviews\ListItems;

use Support\Client\Components\Attributes\ComponentAsListItem;
use Support\Client\Components\Misc\GroupBadgesComponent;

class ListItemGroupBadgesComponent extends GroupBadgesComponent implements ListItemComponent
{
    use ComponentAsListItem;

    /**
     * @param string $value
     * @param string $separator
     *
     * @return $this
     */
    public function convertStringArray(string $value, string $separator = ','): static
    {
        if (empty($value)) {
            return $this->addBadge(
                ListItemBadgeComponent::create()
                    ->setValue(trans('word.no_content'))
                    ->setOutlined()
            );
        }

        return $this->convertArray(explode($separator, $value));
    }
}
