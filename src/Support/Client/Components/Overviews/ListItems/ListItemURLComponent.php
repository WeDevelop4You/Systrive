<?php

namespace Support\Client\Components\Overviews\ListItems;

use Support\Client\Components\Attributes\ComponentAsListItem;
use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Component;
use Support\Client\Components\Utils\ThemeComponent;
use Support\Enums\Component\Vuetify\VuetifyTextColor;

class ListItemURLComponent extends Component implements ListItemComponent
{
    use ComponentAsListItem;
    use ComponentWithClasses;

    protected function __construct()
    {
        parent::__construct();

        $this->setColor(VuetifyTextColor::SECONDARY);
    }

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'URLComponent';
    }

    /**
     * @param mixed $value
     *
     * @return ListItemURLComponent
     */
    public function setValue(mixed $value): static
    {
        if (! empty($value)) {
            $value = prep_url($value);
        }

        return$this->setContent('value', $value);
    }

    /**
     * @param string $anchor
     *
     * @return ListItemURLComponent
     */
    public function setAnchor(string $anchor): ListItemURLComponent
    {
        return $this->setContent('anchor', $anchor);
    }

    /**
     * @param ThemeComponent|VuetifyTextColor $color
     *
     * @return ListItemURLComponent
     */
    public function setColor(VuetifyTextColor|ThemeComponent $color): ListItemURLComponent
    {
        $value = $color instanceof ThemeComponent
            ? $color->export()
            : $color->value;

        return $this->setData('color', $value);
    }
}
