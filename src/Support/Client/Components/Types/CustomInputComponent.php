<?php

namespace Support\Client\Components\Types;

use Support\Enums\Component\Inputs\CustomInputType;

interface CustomInputComponent
{
    /**
     * @param CustomInputType|null $inputType
     *
     * @return $this
     */
    public function setType(CustomInputType|null $inputType = null): static;
}
