<?php

namespace Domain\Cms\Collections;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection as CollectionBase;
use Support\Graphql\Definitions\Entry;
use Support\Graphql\Enums\SortingDirectionEnum;

class CmsColumnCollection extends Collection
{
    /**
     * @return CmsColumnCollection|CollectionBase
     */
    public function createTableStructure(): CollectionBase|CmsColumnCollection
    {
        return $this->map(function (CmsColumn $column, int $index) {
            $component = $column->type()->getColumnComponent();

            if (($this->count() - 1) === $index) {
                $component->setDivider();
            }

            return $component;
        });
    }

    /**
     * @param CmsModel $model
     * @param bool     $readonly
     *
     * @return CmsColumnCollection|CollectionBase
     */
    public function createFormStructure(CmsModel $model, bool $readonly = false): CollectionBase|CmsColumnCollection
    {
        return $this->map(function (CmsColumn $column) use ($model, $readonly) {
            return $column->type()->getInputComponent($model, $readonly);
        });
    }

    /**
     * @param FormRequest $request
     *
     * @return CmsColumnCollection|CollectionBase
     */
    public function createFormRules(FormRequest $request): CollectionBase|CmsColumnCollection
    {
        return $this->mapWithKeys(function (CmsColumn $column) use ($request) {
            return $column->type()->getValidations($request);
        });
    }

    /**
     * @param string $table
     *
     * @return CmsColumnCollection|CollectionBase
     */
    public function createGraphqlFields(string $table): CollectionBase|CmsColumnCollection
    {
        return $this->whereSelectable()->map(function (CmsColumn $column) use ($table) {
            return $column->type()->getGraphqlField($table);
        });
    }

    /**
     * @return CollectionBase|CmsColumnCollection
     */
    public function createGraphqlFilter(): CollectionBase|CmsColumnCollection
    {
        return $this->whereSelectable()->whereFilterable()->map(function (CmsColumn $column) {
            return Entry::create($column->key, $column->type()->getGraphqlFilter());
        });
    }

    /**
     * @return CollectionBase|CmsColumnCollection
     */
    public function createGraphqlSorting(): CollectionBase|CmsColumnCollection
    {
        return $this->whereSelectable()->whereFilterable()->map(function (CmsColumn $column) {
            return Entry::create($column->key, SortingDirectionEnum::create($column->key));
        });
    }

    /**
     * @return CmsColumnCollection
     */
    public function whereFilterable(): CmsColumnCollection
    {
        return $this->whereNotIn(
            CmsColumnTableMap::COL_TYPE,
            [
                CmsColumnType::FILE,
                CmsColumnType::IMAGE,
                CmsColumnType::RICH_TEXT,
            ]
        );
    }

    /**
     * @return CmsColumnCollection
     */
    public function whereSelectable(): CmsColumnCollection
    {
        return $this->where(CmsColumnTableMap::COL_SELECTABLE, true);
    }

    /**
     * @return CmsColumnCollection
     */
    public function whereCreatable(): CmsColumnCollection
    {
        return $this->where(CmsColumnTableMap::COL_CREATABLE, true);
    }

    /**
     * @return CmsColumnCollection
     */
    public function whereUpdatable(): CmsColumnCollection
    {
        return $this->where(CmsColumnTableMap::COL_UPDATABLE, true);
    }
}
