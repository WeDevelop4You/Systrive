<?php

namespace Domain\Cms\Columns\Definitions;

interface DirtyColumn
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isDirty(mixed $value): bool;
}
