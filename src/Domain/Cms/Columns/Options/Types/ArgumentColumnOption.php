<?php

namespace Domain\Cms\Columns\Options\Types;

use Domain\Cms\Columns\Definitions\DirtyColumn;

interface ArgumentColumnOption extends DirtyColumn
{
    /**
     * @return string
     */
    public function getArgumentKey(): string;
}
