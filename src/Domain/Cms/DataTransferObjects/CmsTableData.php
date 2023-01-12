<?php

namespace Domain\Cms\DataTransferObjects;

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
        public readonly bool $editable,
        public readonly bool $isTable = false
    ) {
        $this->columns = Collection::make($columns)->mapInto(CmsColumn::class);
    }
}
