<?php

namespace Domain\Cms\Columns\Options\Types;

use Domain\Cms\Columns\Attributes\DirtyColumn;

interface ArgumentDirtyColumnOption extends DirtyColumn
{
    /**
     * @return string
     */
    public function getArgumentKey(): string;
}
