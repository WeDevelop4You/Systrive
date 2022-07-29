<?php

    namespace Support\Helpers\DataTable\Queries;

    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Str;
    use Support\Helpers\DataTable\Build\Column;

    class OrderQueryBuilder
    {
        /**
         * @var EloquentBuilder|Relation
         */
        private EloquentBuilder|Relation $query;

        /**
         * @var array
         */
        private array $sorting;

        /**
         * @var Collection|Column[]
         */
        private Collection|array $columns;

        /**
         * @param Builder|EloquentBuilder|Relation $query
         * @param Collection                       $columns
         * @param array                            $sorting
         */
        private function __construct(EloquentBuilder|Relation|Builder $query, Collection $columns, array $sorting)
        {
            $this->query = $query;
            $this->sorting = $sorting;
            $this->columns = $columns;
        }

        /**
         * @param Builder|EloquentBuilder|Relation $query
         * @param Collection                       $columns
         * @param array                            $sorting
         *
         * @return Builder|EloquentBuilder|Relation
         */
        public static function create(EloquentBuilder|Relation|Builder $query, Collection $columns, array $sorting): EloquentBuilder|Relation|Builder
        {
            $instance = new static($query, $columns, $sorting);

            return $instance->handle();
        }

        /**
         * @return Builder|EloquentBuilder|Relation
         */
        public function handle(): EloquentBuilder|Relation|Builder
        {
            foreach ($this->sorting as $sorter) {
                [$identifier, $direction] = $this->splitSorter($sorter);

                $column = $this->columns->firstwhere('identifier', $identifier);

                if ($column instanceof Column && $column->isSortable) {
                    if ($column->hasSortCallback()) {
                        App::call($column->getSortCallback(), ['query' => &$this->query, 'direction' => $direction]);
                    } else {
                        $this->query->orderBy($column->getKey(), $direction);
                    }
                }
            }

            return $this->query;
        }

        /**
         * @param string $sorter
         *
         * @return array
         */
        private function splitSorter(string $sorter): array
        {
            $direction = Str::afterLast($sorter, '_');

            if (\in_array($direction, ['asc', 'desc'])) {
                $column = Str::beforeLast($sorter, '_');
            } else {
                $column = $sorter;
                $direction = 'asc';
            }

            return [$column, $direction];
        }
    }
