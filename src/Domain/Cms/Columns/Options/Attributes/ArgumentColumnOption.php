<?php

namespace Domain\Cms\Columns\Options\Attributes;

interface ArgumentColumnOption extends ValidationColumnOption
{
    /**
     * @return string
     */
    public function getArgumentKey(): string;
}
