<?php

namespace Support\Response\Components\Items;

use Support\Enums\Vuetify\VuetifyColors;
use function trans;

class ItemBadgeComponent extends AbstractItemComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Badge';
    }

    /**
     * @return ItemBadgeComponent
     */
    public function setOutlined(): ItemBadgeComponent
    {
        return $this->setAttribute('outlined', true);
    }

    /**
     * @param VuetifyColors $color
     *
     * @return ItemBadgeComponent
     */
    public function setColor(VuetifyColors $color): ItemBadgeComponent
    {
        return $this->setAttribute('color', $color->value);
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

        if (!empty($value) && in_array($value, $activeValues)) {
            return $this->setColor(VuetifyColors::SUCCESS)
                ->setValue(trans('word.active.active'));
        }

        return $this->setColor(VuetifyColors::ERROR)
            ->setValue(trans('word.inactive.inactive'));
    }
}
