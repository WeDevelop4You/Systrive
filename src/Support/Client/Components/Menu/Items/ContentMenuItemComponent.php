<?php

namespace Support\Client\Components\Menu\Items;

class ContentMenuItemComponent extends AbstractMenuItemComponent
{
    /**
     * @param string $title
     *
     * @return ContentMenuItemComponent
     */
    public function setTitle(string $title): ContentMenuItemComponent
    {
        return $this->setContent('title', $title);
    }
}
