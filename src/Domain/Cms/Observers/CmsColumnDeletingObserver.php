<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Models\CmsColumn;

class CmsColumnDeletingObserver
{
    public function deleting(CmsColumn $column): bool
    {
        if (CmsColumn::isRequired($column->key)) {
            return false;
        }

        return true;
    }
}
