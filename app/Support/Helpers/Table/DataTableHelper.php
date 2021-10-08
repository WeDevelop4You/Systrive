<?php

    namespace Support\Helpers\Table;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Support\Helpers\Table\Queries\SortingQueryBuilder;

    class DataTableHelper
    {
        /**
         * @var Builder
         */
        private Builder $query;

        /**
         * @var Request
         */
        private Request $request;

        /**
         * @var array
         */
        private array $sortableColumns = [];

        /**
         * @var array
         */

        private array $searchableColumns = [];

        /**
         * @param Builder $query
         * @throws BindingResolutionException
         */
        public function __construct(Builder $query)
        {
            $this->query = $query;
            $this->request = Container::getInstance()->make('request');
        }

        /**
         * @param Builder $query
         * @return DataTableHelper
         * @throws BindingResolutionException
         */
        public static function create(Builder $query): DataTableHelper
        {
            return new static($query);
        }

        /**
         * @param array $sortableColumns
         */
        public function setSortableColumns(array $sortableColumns): void
        {
            $this->sortableColumns = $sortableColumns;
        }

        /**
         * @param array $searchableColumns
         */
        public function setSearchableColumns(array $searchableColumns): void
        {
            $this->searchableColumns = $searchableColumns;
        }

        private function addSearchToQuery()
        {

        }

        private function addSortingToQuery()
        {
            $this->query = SortingQueryBuilder::create(
                $this->query,
                $this->sortableColumns,
                $this->request->query('sorting')
            )->builder();
        }

        /**
         * @return LengthAwarePaginator
         */
        public function get(): LengthAwarePaginator
        {
            if ($this->request->query->has('search')) {
                $this->addSearchToQuery();
            }

            if ($this->request->query->has('sorting')) {
                $this->addSortingToQuery();
            }

            return $this->query->paginate($this->request->query('itemPerPage', 10));
        }
    }
