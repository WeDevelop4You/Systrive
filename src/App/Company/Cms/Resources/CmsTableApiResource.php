<?php

namespace App\Company\Cms\Resources;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CmsTable
 */
class CmsTableApiResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            CmsTableTableMap::COL_QUERY => $this->query,
            CmsTableTableMap::COL_MUTABLE => (bool) $this->mutable,
            CmsTableTableMap::COL_QUERYABLE => (bool) $this->queryable,
            CmsTableTableMap::COL_DELETABLE => (bool) $this->deletable,
            CmsColumnTableMap::COL_SELECTABLE => $this->sortedColumns->map(
                fn (CmsColumn $column) => $this->createCheckBox($column, CmsColumnTableMap::COL_SELECTABLE)
            ),
            CmsColumnTableMap::COL_CREATABLE => $this->mutableColumns->map(
                fn (CmsColumn $column) => $this->createCheckBox($column, CmsColumnTableMap::COL_CREATABLE)
            ),
            CmsColumnTableMap::COL_UPDATABLE => $this->mutableColumns->map(
                fn (CmsColumn $column) => $this->createCheckBox($column, CmsColumnTableMap::COL_UPDATABLE)
            ),
        ];
    }

    /**
     * @param CmsColumn $column
     * @param string    $field
     *
     * @return array
     */
    private function createCheckBox(CmsColumn $column, string $field): array
    {
        return [
            'title' => $column->key,
            'value' => (bool) $column->getAttributeValue($field),
        ];
    }
}
