<?php

    namespace Support\Helpers\Data\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Str;
    use Support\Helpers\Data\Build\Column;

    class OrderQueryBuilder
    {
        /**
         * @var Builder
         */
        private Builder $query;

        /**
         * @var array
         */
        private array $sorting;

        /**
         * @var Collection|Column[]
         */
        private Collection $columns;

        /**
         * @param Builder    $query
         * @param Collection $columns
         * @param array      $sorting
         */
        public function __construct(Builder $query, Collection $columns, array $sorting)
        {
            $this->query = $query;
            $this->sorting = $sorting;
            $this->columns = $columns;
        }

        /**
         * @param Builder    $query
         * @param Collection $columns
         * @param array      $sorting
         *
         * @return OrderQueryBuilder
         */
        public static function create(Builder $query, Collection $columns, array $sorting): OrderQueryBuilder
        {
            return new static($query, $columns, $sorting);
        }

        /**
         * @return Builder
         */
        public function build(): Builder
        {
            foreach ($this->sorting as $sorter) {
                [$columnName, $direction] = $this->splitSorter($sorter);

                $column = $this->columns->firstwhere('columnName', $columnName);

                if (!is_null($column) && $column->isSortable) {
                    if ($column->hasSortCallback()) {
                        $this->query = App::call($column->sortCallback, ['query' => $this->query, 'direction' => $direction]);
                    } else {
                        $this->query->orderBy($columnName, $direction);
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
                $column = Str::BeforeLast($sorter, '_');
            } else {
                $column = $sorter;
                $direction = 'asc';
            }

            return [$column, $direction];
        }
    }
