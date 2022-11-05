<?php

namespace Domain\Cms\Actions;

use Domain\Cms\Models\CmsTable;
use Illuminate\Support\Facades\Schema;

class CmsTableDestroyAction
{
    /**
     * @param CmsTable $table
     *
     * @return int
     */
    public function __invoke(CmsTable $table): int
    {
        Schema::connection('cms')->dropIfExists($table->name);

        return $table->delete();
    }
}
