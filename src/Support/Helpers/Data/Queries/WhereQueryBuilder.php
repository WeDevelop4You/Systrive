<?php

    namespace Support\Helpers\Data\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Schema;
    use Support\Helpers\Data\Build\Column;
    use Support\Helpers\Data\ColumnHelper;
    use Support\Traits\DatabaseEnumSearch;

    class WhereQueryBuilder
    {
        /**
         * @var Builder|Relation
         */
        private Builder|Relation $query;

        /**
         * @var string
         */
        private string $search;

        /**
         * @var Collection|Column[]
         */
        private Collection|array $columns;

        /**
         * @param Builder|Relation $query
         * @param Collection       $columns
         * @param string           $search
         */
        public function __construct(Relation|Builder $query, Collection $columns, string $search)
        {
            $this->query = $query;
            $this->columns = $columns;
            $this->search = trim($search);
        }

        /**
         * @param Builder|Relation $query
         * @param Collection       $columns
         * @param string           $search
         *
         * @return WhereQueryBuilder
         */
        public static function create(Relation|Builder $query, Collection $columns, string $search): WhereQueryBuilder
        {
            return new static($query, $columns, $search);
        }

        /**
         * @return Builder|Relation
         */
        public function build(): Relation|Builder
        {
            $searchableColumns = $this->columns->where('isSearchable', true);

            if ($searchableColumns->isNotEmpty()) {
                $this->query->where(function (Relation|Builder $subQuery) use ($searchableColumns) {
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
                        } elseif (!$hasRelation || $selectedColumn) {
                            $whereColumn = $selectedColumn ?? $key;

                            if (!$hasRelation) {
                                $whereColumn = Schema::hasColumn($this->query->getModel()->getTable(), $whereColumn) ? $this->query->getModel()->getTable() . '.' . $whereColumn : $whereColumn;
                            }

                            $subQuery->orWhere($whereColumn, 'like', "%{$this->search}%");
                        } else {
                            $relationName = ColumnHelper::parseRelation($key);
                            $fieldName = ColumnHelper::parseField($key);

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
