<?php

namespace Support\Client\Components\Overviews\ListItems;

interface ListItemComponent
{
    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): static;

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue(mixed $value): static;

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setCondition(bool $condition): static;

    /**
     * @return bool
     */
    public function getCondition(): bool;
}
