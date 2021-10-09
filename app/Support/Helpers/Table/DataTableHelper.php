<?php

    namespace Support\Helpers\Table;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Support\Helpers\Table\Queries\SearchQueryBuilder;
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
         * @var Collection|TableColumn[]
         */
        private Collection $columns;

        /**
         * @param Builder $query
         * @throws BindingResolutionException
         */
        public function __construct(Builder $query)
        {
            $this->query = $query;
            $this->columns = new Collection();
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
         * @param TableColumn $column
         * @return DataTableHelper
         */
        public function addColumns(TableColumn $column): DataTableHelper
        {
            $this->columns->push($column);

            return $this;
        }

        /**
         * @param array $columns
         * @return DataTableHelper
         */
        public function setColumns(array $columns): DataTableHelper
        {
            $this->columns = new Collection($columns);

            return $this;
        }

        private function addSearchToQuery()
        {
            $this->query = SearchQueryBuilder::create(
                $this->query,
                $this->columns,
                $this->request->query('search')
            )->builder();
        }

        private function addSortingToQuery()
        {
            $this->query = SortingQueryBuilder::create(
                $this->query,
                $this->columns,
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
