<?php

    namespace Support\Helpers\Data\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Str;
    use Support\Helpers\Data\Build\Column;

    class OrderQueryBuilder
    {
        /**
         * @var Builder|Relation
         */
        private Builder|Relation $query;

        /**
         * @var array
         */
        private array $sorting;

        /**
         * @var Collection|Column[]
         */
        private Collection|array $columns;

        /**
         * @param Builder|Relation $query
         * @param Collection       $columns
         * @param array            $sorting
         */
        public function __construct(Relation|Builder $query, Collection $columns, array $sorting)
        {
            $this->query = $query;
            $this->sorting = $sorting;
            $this->columns = $columns;
        }

        /**
         * @param Builder|Relation $query
         * @param Collection       $columns
         * @param array            $sorting
         *
         * @return OrderQueryBuilder
         */
        public static function create(Relation|Builder $query, Collection $columns, array $sorting): OrderQueryBuilder
        {
            return new static($query, $columns, $sorting);
        }

        /**
         * @return Builder|Relation
         */
        public function build(): Relation|Builder
        {
            foreach ($this->sorting as $sorter) {
                [$identifier, $direction] = $this->splitSorter($sorter);

                $column = $this->columns->firstwhere('identifier', $identifier);

                if ($column instanceof Column && $column->isSortable) {
                    if ($column->hasSortCallback()) {
                        App::call($column->getSortCallback(), ['query' => &$this->query, 'direction' => $direction]);
                    } else {
                        $this->query->orderBy($identifier, $direction);
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

            if (in_array($direction, ['asc', 'desc'])) {
                $column = Str::beforeLast($sorter, '_');
            } else {
                $column = $sorter;
                $direction = 'asc';
            }

            return [$column, $direction];
        }
    }
