<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Models\CmsTable;

class CmsTableSavingObserver
{
    public function saving(CmsTable $table): void
    {
        if (!$table->is_table) {
            $table->deletable = false;
        }
    }
}
