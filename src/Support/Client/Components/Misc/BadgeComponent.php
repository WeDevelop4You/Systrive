<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\Vuetify\VuetifyColor;

class BadgeComponent extends Component
{
    use ComponentWithClasses;

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'BadgeComponent';
    }

    /**
     * @return static
     */
    public function setOutlined(): static
    {
        return $this->setAttribute('outlined', true);
    }

    /**
     * @param ThemeComponent|VuetifyColor $color
     *
     * @return static
     */
    public function setColor(VuetifyColor|ThemeComponent $color): static
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setAttribute('color', $value);
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        return $this->setContent('value', $value);
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

        if (! empty($value) && \in_array($value, $activeValues)) {
            return $this->setColor(VuetifyColor::SUCCESS)
                ->setValue(trans('word.active.active'));
        }

        return $this->setColor(VuetifyColor::ERROR)
            ->setValue(trans('word.inactive.inactive'));
    }
}
