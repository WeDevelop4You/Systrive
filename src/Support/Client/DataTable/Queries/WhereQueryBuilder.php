<?php

namespace Support\Client\DataTable\Queries;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Support\Client\DataTable\Build\Column;
use Support\Helpers\ColumnHelper;
use Support\Traits\DatabaseEnumSearch;

class WhereQueryBuilder
{
    /**
     * @var Builder|EloquentBuilder|Relation
     */
    private EloquentBuilder|Relation|Builder $query;

    /**
     * @var string
     */
    private string $search;

    /**
     * @var Collection|Column[]
     */
    private Collection|array $columns;

    /**
     * @param Builder|EloquentBuilder|Relation $query
     * @param Collection                       $columns
     * @param string                           $search
     */
    private function __construct(EloquentBuilder|Relation|Builder $query, Collection $columns, string $search)
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->search = trim($search);
    }

    /**
     * @param Builder|EloquentBuilder|Relation $query
     * @param Collection                       $columns
     * @param string                           $search
     *
     * @return Builder|EloquentBuilder|Relation
     */
    public static function create(EloquentBuilder|Relation|Builder $query, Collection $columns, string $search): EloquentBuilder|Relation|Builder
    {
        $instance = new static($query, $columns, $search);

        return $instance->handle();
    }

    /**
     * @return Builder|EloquentBuilder|Relation
     */
    public function handle(): EloquentBuilder|Relation|Builder
    {
        $searchableColumns = $this->columns->where('isSearchable', true);

        if ($searchableColumns->isNotEmpty()) {
            $this->query->where(function (Relation|EloquentBuilder $subQuery) use ($searchableColumns) {
                $searchableColumns->each(function (Column $column) use ($subQuery) {
                    $key = $column->getKey();
                    $hasRelation = ColumnHelper::hasRelation($key);
                    $selectedColumn = ColumnHelper::mapToSelected($key, $this->query);

                    if ($column->hasSearchCallback()) {
                        $searchCallback = $column->getSearchCallback();

                        if ($column->isEnumSearch) {
                            /** @var DatabaseEnumSearch $searchCallback */
                            $subQuery->orWhereIn($key, $searchCallback::search($this->search));
                        } else {
                            App::call($searchCallback, ['query' => &$subQuery, 'search' => $this->search]);
                        }
                    } elseif (! $hasRelation || $selectedColumn) {
                        $whereColumn = $selectedColumn ?? $key;

                        if (! $hasRelation) {
                            $whereColumn = Schema::hasColumn($this->query->getModel()->getTable(), $whereColumn) ? $this->query->getModel()->getTable().'.'.$whereColumn : $whereColumn;
                        }

                        $subQuery->orWhere($whereColumn, 'like', "%{$this->search}%");
                    } else {
                        $relationName = ColumnHelper::parseRelation($key);
                        $fieldName = ColumnHelper::parseField($key);

                        $subQuery->orWhereHas($relationName, function (EloquentBuilder $hasQuery) use ($fieldName) {
                            $hasQuery->where($fieldName, 'like', "%{$this->search}%");
                        });
                    }
                });
            });
        }

        return $this->query;
    }
}
