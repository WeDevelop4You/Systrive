<?php

namespace Support\Response\Components\Items;

use Domain\System\Models\SystemTemplate;
use Support\Enums\System\SystemTemplateTypes;

class ItemTextComponent extends AbstractItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Content';
    }

    /**
     * @param string              $value
     * @param SystemTemplateTypes $type
     *
     * @return ItemTextComponent
     */
    public function setTemplate(string $value, SystemTemplateTypes $type): ItemTextComponent
    {
        $template = SystemTemplate::whereValueAndType($value, $type)->first();

        return self::setValue($template->name ?? trans('word.unknown.template'));
    }
}
