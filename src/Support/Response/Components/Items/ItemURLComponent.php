<?php

namespace Support\Response\Components\Items;

use Support\Enums\Vuetify\VuetifyTextColors;

class ItemURLComponent extends AbstractItemComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setColor(VuetifyTextColors::SECONDARY);
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'URL';
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
     * @param VuetifyTextColors $color
     *
     * @return ItemURLComponent
     */
    public function setColor(VuetifyTextColors $color): ItemURLComponent
    {
        return $this->setData('color', $color->value);
    }
}
