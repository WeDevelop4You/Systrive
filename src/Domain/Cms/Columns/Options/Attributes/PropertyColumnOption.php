<?php

namespace Domain\Cms\Columns\Options\Attributes;

use Domain\Cms\Models\CmsColumn;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

interface PropertyColumnOption extends ValidationColumnOption
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
