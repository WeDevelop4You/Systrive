<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;

class StringComponent extends Component
{
    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text): static
    {
        return $this->setContent('text', $text);
    }
}
