<?php

namespace Support\Response\Components\Items;

use Domain\System\Models\SystemTemplate;
use Support\Enums\System\SystemTemplateType;

class ItemTextComponent extends AbstractItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'ContentComponent';
    }

    /**
     * @param string             $value
     * @param SystemTemplateType $type
     *
     * @return ItemTextComponent
     */
    public function setTemplate(string $value, SystemTemplateType $type): ItemTextComponent
    {
        $template = SystemTemplate::whereValueAndType($value, $type)->first();

        return self::setValue($template->name ?? trans('word.unknown.template'));
    }
}
