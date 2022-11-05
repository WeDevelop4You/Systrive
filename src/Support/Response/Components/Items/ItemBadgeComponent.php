<?php

namespace Support\Response\Components\Items;

use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Response\Components\Utils\ThemeComponent;

class ItemBadgeComponent extends AbstractItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'BadgeComponent';
    }

    /**
     * @return ItemBadgeComponent
     */
    public function setOutlined(): ItemBadgeComponent
    {
        return $this->setAttribute('outlined', true);
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return ItemBadgeComponent
     */
    public function setColor(VuetifyColor|ThemeComponent $color): ItemBadgeComponent
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @param mixed $value
     * @param bool  $reversed
     *
     * @return $this
     */
    public function setVesta(mixed $value, bool $reversed = false): static
    {
        $this->setOutlined();

        $activeValues = $reversed
            ? ['no', 'disabled']
            : ['yes', 'enabled'];

        if (!empty($value) && \in_array($value, $activeValues)) {
            return $this->setColor(VuetifyColor::SUCCESS)
                ->setValue(trans('word.active.active'));
        }

        return $this->setColor(VuetifyColor::ERROR)
            ->setValue(trans('word.inactive.inactive'));
    }
}
