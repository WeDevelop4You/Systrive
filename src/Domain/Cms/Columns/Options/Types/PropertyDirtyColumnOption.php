<?php

namespace Domain\Cms\Columns\Options\Types;

use Domain\Cms\Columns\Attributes\DirtyColumn;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

interface PropertyDirtyColumnOption extends DirtyColumn
{
    /**
     * @param ColumnDefinition $columnDefinition
     * @param Blueprint        $table
     * @param CmsColumn        $column
     *
     * @return void
     */
    public function getProperty(ColumnDefinition $columnDefinition, Blueprint $table, CmsColumn $column): void;
}
