<?php

    namespace Support\Helpers\Table\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Schema;
    use Support\Helpers\Table\Build\Column;
    use Support\Helpers\Table\ColumnHelper;

    class WhereQueryBuilder
    {
        /**
         * @var Builder
         */
        private Builder $query;

        /**
         * @var string
         */
        private string $search;

        /**
         * @var Collection|Column[]
         */
        private Collection $columns;

        /**
         * @param Builder $query
         * @param Collection $columns
         * @param string $search
         */
        public function __construct(Builder $query, Collection $columns, string $search)
        {
            $this->query = $query;
            $this->columns = $columns;
            $this->search = trim($search);
        }

        /**
         * @param Builder $query
         * @param Collection $columns
         * @param string $search
         * @return WhereQueryBuilder
         */
        public static function create(Builder $query, Collection $columns, string $search): WhereQueryBuilder
        {
            return new static($query, $columns, $search);
        }

        public function build(): Builder
        {
            $searchableColumns = $this->columns->where('isSearchable', true);

            if ($searchableColumns->isNotEmpty()) {
                $this->query->where(function (Builder $subQuery) use ($searchableColumns) {
                    $searchableColumns->each(function (Column $column) use ($subQuery) {
                        $hasRelation = ColumnHelper::hasRelation($column->columnName);

                        $selectedColumn = ColumnHelper::mapToSelected($column->columnName, $this->query);

                        if ($column->hasSearchCallback()) {
                            ($column->searchCallback)($subQuery, $this->search);
                        } elseif (!$hasRelation || $selectedColumn) {
                            $whereColumn = $selectedColumn ?? $column->columnName;

                            if (!$hasRelation) {
                                $whereColumn = Schema::hasColumn($this->query->getModel()->getTable(), $whereColumn) ? $this->query->getModel()->getTable() . '.' . $whereColumn : $whereColumn;
                            }

                            $subQuery->orWhere($whereColumn, 'like', "%{$this->search}%");
                        } else {
                            $relationName = ColumnHelper::parseRelation($column->columnName);
                            $fieldName = ColumnHelper::parseField($column->columnName);

                            $subQuery->orWhereHas($relationName, function (Builder $hasQuery) use ($fieldName) {
                                $hasQuery->where($fieldName, 'like', "%{$this->search}%");
                            });
                        }
                    });
                });
            }

            return  $this->query;
        }
    }
