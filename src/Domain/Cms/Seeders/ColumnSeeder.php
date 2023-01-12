<?php

namespace Domain\Cms\Seeders;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractSeeder;

class ColumnSeeder extends AbstractSeeder
{
    /**
     * @return Collection
     */
    protected function handler(): Collection
    {
        return Collection::make([
            CmsColumn::make([
                CmsColumnTableMap::COL_KEY => 'id',
                CmsColumnTableMap::COL_LABEL => 'ID',
                CmsColumnTableMap::COL_EDITABLE => false,
                CmsColumnTableMap::COL_DELETABLE => false,
                CmsColumnTableMap::COL_TYPE => CmsColumnType::ID,
            ]),
            CmsColumn::make([
                CmsColumnTableMap::COL_KEY => 'created_at',
                CmsColumnTableMap::COL_LABEL => 'Create at',
                CmsColumnTableMap::COL_EDITABLE => false,
                CmsColumnTableMap::COL_DELETABLE => false,
                CmsColumnTableMap::COL_TYPE => CmsColumnType::DATETIME,
            ]),
            CmsColumn::make([
                CmsColumnTableMap::COL_KEY => 'updated_at',
                CmsColumnTableMap::COL_LABEL => 'Update at',
                CmsColumnTableMap::COL_EDITABLE => false,
                CmsColumnTableMap::COL_DELETABLE => false,
                CmsColumnTableMap::COL_TYPE => CmsColumnType::DATETIME,
            ]),
        ]);
    }
}
