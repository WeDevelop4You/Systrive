<?php

namespace Support\Response\Components\Items;

use Support\Enums\Component\Vuetify\VuetifyTextColor;
use Support\Response\Components\Utils\ThemeComponent;

class ItemURLComponent extends AbstractItemComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setColor(VuetifyTextColor::SECONDARY);
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'URLComponent';
    }

    /**
     * @param mixed $value
     *
     * @return ItemURLComponent
     */
    public function setValue(mixed $value): static
    {
        if (!empty($value)) {
            $value = prep_url($value);
        }

        return parent::setValue($value);
    }

    /**
     * @param string $anchor
     *
     * @return ItemURLComponent
     */
    public function setAnchor(string $anchor): ItemURLComponent
    {
        return $this->setContent('anchor', $anchor);
    }

    /**
     * @param ThemeComponent|VuetifyTextColor $color
     *
     * @return ItemURLComponent
     */
    public function setColor(VuetifyTextColor|ThemeComponent $color): ItemURLComponent
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setData('color', $value);
    }
}
