<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Illuminate\Validation\Rule;
use Support\Abstracts\AbstractRequest;

/**
 * @property CmsTable $table
 */
class CmsTableApiRequest extends AbstractRequest
{
    /**
     * @var string[]
     */
    private array $mutable;

    /**
     * @var string[]
     */
    private array $queryable;

    /**
     * @return bool
     */
    protected function isUpdating(): bool
    {
        return $this->table->is_table;
    }

    /**
     * @inheritDoc
     */
    protected function defaultRules(): array
    {
        $this->mutable = $this->table->mutableColumns->pluck(CmsColumnTableMap::COL_KEY)->toArray();
        $this->queryable = $this->table->sortedColumns->pluck(CmsColumnTableMap::COL_KEY)->toArray();

        return [
            CmsTableTableMap::COL_QUERY => ['required', 'string', Rule::unique(CmsTable::class)->ignore($this->table->id)],
            CmsTableTableMap::COL_QUERYABLE => ['required', 'boolean'],
            CmsTableTableMap::COL_MUTABLE => ['required', 'boolean'],
            CmsColumnTableMap::COL_SELECTABLE => ['required', 'array'],
            CmsColumnTableMap::COL_UPDATABLE => ['required', 'array'],
            CmsColumnTableMap::COL_SELECTABLE_ALL => Rule::forEach(fn () => $this->allRules($this->queryable)),
            CmsColumnTableMap::COL_UPDATABLE_ALL => Rule::forEach(fn () => $this->allRules($this->mutable)),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function storeRules(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    protected function updateRules(): array
    {
        return [
            CmsTableTableMap::COL_DELETABLE => ['required', 'boolean'],
            CmsColumnTableMap::COL_CREATABLE => ['required', 'array'],
            CmsColumnTableMap::COL_CREATABLE_ALL => Rule::forEach(fn () => $this->allRules($this->mutable)),
        ];
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    private function allRules(array $keys): array
    {
        return [
            'value' => ['required', 'boolean'],
            'title' => ['required', 'string', Rule::in($keys)],
        ];
    }
}
