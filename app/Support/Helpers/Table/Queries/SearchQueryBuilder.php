<?php

    namespace Support\Helpers\Table\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Str;
    use Support\Helpers\Table\TableColumn;

    class SearchQueryBuilder
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
         * @var Collection|TableColumn[]
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
         * @return SearchQueryBuilder
         */
        public static function create(Builder $query, Collection $columns, string $search): SearchQueryBuilder
        {
            return new static($query, $columns, $search);
        }

        public function builder(): Builder
        {
            $searchableColumns = $this->columns->where('isSearchable', true);

            if ($searchableColumns->isNotEmpty()) {
                $this->query->where(function (Builder $subQuery) use ($searchableColumns) {
                    $searchableColumns->each(function(TableColumn $column) use ($subQuery) {
                        $hasRelation = Str::contains($this->columns, '.');;

                        $selectedColumn = '';

                        if ($column->hasSearchCallback()) {
                            $this->query = App::call($column->searchCallback, [$subQuery, $this->query]);
                        } else if (!$hasRelation || $selectedColumn) {
                            $whereColumn = $selectedColumn ?? $column->columnName;

                            if (!$hasRelation) {
                                $whereColumn = Schema::hasColumn($this->query->getModel()->getTable(), $whereColumn) ? $this->query->getModel()->getTable() . '.' . $whereColumn : $whereColumn;
                            }

                            $subQuery->orWhere($whereColumn, 'like', "%{$this->search}%");
                        } else {
                            $relationName = Str::beforeLast($column->columnName, '.');
                            $fieldName = Str::afterLast($column->columnName, '.');

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
