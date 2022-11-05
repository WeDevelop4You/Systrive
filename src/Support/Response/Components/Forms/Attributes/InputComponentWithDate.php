<?php

namespace Support\Response\Components\Forms\Attributes;

trait InputComponentWithDate
{
    /**
     * @param string $format
     *
     * @return $this
     */
    public function setDateFormat(string $format): static
    {
        return $this->setData('dateFormat', $format);
    }
}
