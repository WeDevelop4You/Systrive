<?php

namespace Domain\Cms\Columns\Attributes;

interface DirtyColumn
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isDirty(mixed $value): bool;
}
