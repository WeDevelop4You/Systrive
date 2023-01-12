<?php

namespace Support\Client\Components\Forms\Attributes;

trait InputComponentWithTime
{
    /**
     * @return $this
     */
    public function setUseSeconds(bool $condition = true): static
    {
        if ($condition) {
            $this->setTimeFormat('HH:mm:ss');
        } else {
            $this->setTimeFormat('HH:mm');
        }

        return $this->setData('useSeconds', $condition);
    }

    /**
     * @param string $format
     *
     * @return $this
     */
    public function setTimeFormat(string $format): static
    {
        return $this->setData('timeFormat', $format);
    }
}
