<?php

namespace Support\Client\Traits;

trait ComponentWithCol
{
    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setDefaultCol(string|int $length = 12): static
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('cols', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setSmCol(string|int $length = 12): static
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('sm', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setMdCol(string|int $length = 12): static
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('md', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setLgCol(string|int $length = 12): static
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('lg', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setXlCol(string|int $length = 12): static
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('xl', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return bool
     */
    private function isBetween(string|int $length): bool
    {
        return $length === 'auto' || ($length <= 12 && $length > 0);
    }
}
