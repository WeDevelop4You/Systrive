<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;

class CmsColumnSavingObserver
{
    public function saving(CmsColumn $column): void
    {
        $column->offsetUnset(CmsColumnTableMap::COL_ORIGINAL_KEY);

        if (CmsColumn::isRequired($column->key)) {
            $column->editable = false;
            $column->deletable = false;
        }

        if ($column->type === CmsColumnType::RICH_TEXT) {
            $column->hidden = true;
        }
    }
}
