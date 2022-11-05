<?php

namespace Domain\Cms\DataTransferObjects;

use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Support\Collection;

final class CmsTableData
{
    /**
     * @var CmsColumn[]|Collection
     */
    public readonly Collection|array $columns;

    public function __construct(
        array $columns,
        public readonly string $name,
        public readonly string $label,
        public readonly bool $editable
    ) {
        $this->columns = Collection::make($columns)
            ->map(function(array $column) {
                $model = new CmsColumn($column);

                if (in_array($model->key, CmsTableTableMap::REQUIRED_COLUMNS)) {
                    $model->editable = false;
                    $model->deletable = false;
                }

                return $model;
            });
    }
}
