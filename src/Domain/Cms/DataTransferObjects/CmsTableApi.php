<?php

namespace Domain\Cms\DataTransferObjects;

use Domain\Cms\Models\CmsColumn;
use Illuminate\Support\Arr;

final class CmsTableApi
{
    /**
     * @var array
     */
    private array $selectable = [];

    /**
     * @var array
     */
    private array $creatable = [];

    /**
     * @var array
     */
    private array $updatable = [];

    /**
     * CmsTableApi constructor
     *
     * @param string $query
     * @param bool   $queryable
     * @param bool   $mutable
     * @param bool   $deletable
     * @param array  $selectable
     * @param array  $creatable
     * @param array  $updatable
     */
    public function __construct(
        public readonly string $query,
        public readonly bool $queryable,
        public readonly bool $mutable,
        array $selectable,
        array $creatable,
        array $updatable,
        public readonly bool $deletable = false,
    ) {
        foreach ($selectable as $item) {
            $this->selectable[$item['title']] = $item['value'];
        }

        if ($mutable) {
            foreach ($creatable as $item) {
                $this->creatable[$item['title']] = $item['value'];
            }

            foreach ($updatable as $item) {
                $this->updatable[$item['title']] = $item['value'];
            }
        }
    }

    public function setColumnData(CmsColumn $column): void
    {
        $column->selectable = Arr::get($this->selectable, $column->key, false);
        $column->creatable = Arr::get($this->creatable, $column->key, false);
        $column->updatable = Arr::get($this->updatable, $column->key, false);
    }
}
