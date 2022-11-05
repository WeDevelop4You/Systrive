<?php

namespace Support\Response\Components\Forms\Attributes;

trait InputComponentWithCounter
{
    /**
     * @param int $length
     *
     * @return static
     */
    public function setCounter(int $length): static
    {
        return $this->setAttribute('counter', true)
            ->setAttribute('maxlength', $length);
    }
}
