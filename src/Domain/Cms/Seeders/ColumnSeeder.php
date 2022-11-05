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
                CmsColumnTableMap::KEY => 'id',
                CmsColumnTableMap::LABEL => 'ID',
                CmsColumnTableMap::EDITABLE => false,
                CmsColumnTableMap::DELETABLE => false,
                CmsColumnTableMap::TYPE => CmsColumnType::ID,
            ]),
            CmsColumn::make([
                CmsColumnTableMap::KEY => 'created_at',
                CmsColumnTableMap::LABEL => 'Create at',
                CmsColumnTableMap::EDITABLE => false,
                CmsColumnTableMap::DELETABLE => false,
                CmsColumnTableMap::TYPE => CmsColumnType::DATETIME,
            ]),
            CmsColumn::make([
                CmsColumnTableMap::KEY => 'updated_at',
                CmsColumnTableMap::LABEL => 'Update at',
                CmsColumnTableMap::EDITABLE => false,
                CmsColumnTableMap::DELETABLE => false,
                CmsColumnTableMap::TYPE => CmsColumnType::DATETIME,
            ]),
        ]);
    }
}
