<?php

namespace Support\Client\Definitions;

use Support\Enums\Component\Inputs\CustomInputType;

interface CustomInputComponentType
{
    /**
     * @param CustomInputType|null $inputType
     *
     * @return $this
     */
    public function setType(CustomInputType|null $inputType = null): static;
}
