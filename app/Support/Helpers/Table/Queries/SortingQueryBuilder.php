<?php

    namespace Support\Helpers\Table\Queries;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Str;

    class SortingQueryBuilder
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
         * @var array
         */
        private array $sortableColumns;

        public function __construct(Builder $query, array $sortableColumns, array $sorting)
        {
            $this->query = $query;
            $this->sorting = $sorting;
            $this->sortableColumns = $sortableColumns;
        }

        /**
         * @param Builder $query
         * @param array $sortableColumns
         * @param array $sorting
         * @return SortingQueryBuilder
         */
        public static function create(Builder $query, array $sortableColumns, array $sorting): SortingQueryBuilder
        {
            return new static($query, $sortableColumns, $sorting);
        }

        /**
         * @return Builder
         */
        public function builder(): Builder
        {
            foreach ($this->sorting as $sorter) {
                $sorterDetails = $this->validateSorter($sorter);

                if (!is_null($sorterDetails)) {
                    [$column, $direction] = $sorterDetails;

                    $this->query->orderBy($column, $direction);
                }
            }

            return $this->query;
        }

        /**
         * @param string $sorter
         * @return array|null
         */
        private function validateSorter(string $sorter): ?array
        {
            $direction = Str::afterLast($sorter, '_');

            if (in_array($direction, ['asc', 'desc'])) {
                $column = Str::BeforeLast($sorter, '_');
            } else {
                $column = $sorter;
                $direction = 'asc';
            }

            return in_array($column, $this->sortableColumns) || empty($this->sortableColumns)
                ? [$column, $direction]
                : null;
        }
    }
