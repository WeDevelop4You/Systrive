<?php

namespace Domain\Cms\Actions;

use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;
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
