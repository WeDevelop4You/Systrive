<?php

namespace Support\Response\Components\Utils;

use Support\Enums\Component\Vuetify\VuetifyColor;

class ThemeComponent
{
    /**
     * ThemeComponent constructor.
     *
     * @param VuetifyColor $dark
     * @param VuetifyColor $light
     */
    public function __construct(
        private readonly VuetifyColor $dark,
        private readonly VuetifyColor $light,
    ) {
        //
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'dark' => $this->dark->value,
            'light' => $this->light->value
        ];
    }
}
