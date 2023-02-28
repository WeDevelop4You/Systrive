<?php

namespace Support\Client\Components\Overviews\ListItems;

use Domain\System\Models\SystemTemplate;
use Support\Client\Components\Misc\ContentComponent;
use Support\Client\Traits\ComponentAsListItem;
use Support\Enums\System\SystemTemplateType;

class ListItemContentComponent extends ContentComponent implements ListItemComponent
{
    use ComponentAsListItem;

    /**
     * @param string             $value
     * @param SystemTemplateType $type
     *
     * @return ListItemContentComponent
     */
    public function setTemplate(string $value, SystemTemplateType $type): ListItemContentComponent
    {
        $template = SystemTemplate::whereValueAndType($value, $type)->first();

        return self::setValue($template->name ?? trans('word.unknown.template'));
    }
}
