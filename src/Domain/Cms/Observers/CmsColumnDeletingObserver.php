<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsColumn;

class CmsColumnDeletingObserver
{
    public function deleting(CmsColumn $column): bool
    {
        if (\in_array($column->key, CmsTableTableMap::REQUIRED_COLUMNS)) {
            return false;
        }

        return true;
    }
}
