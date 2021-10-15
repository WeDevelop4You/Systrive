<?php

    namespace Support\Helpers\Table\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Helpers\Table\Queries\WhereQueryBuilder;
    use Support\Helpers\Table\Queries\OrderQueryBuilder;

    class DataTable
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
         * @var Collection|Column[]
         */
        private Collection $columns;

        /**
         * @param Builder $query
         */
        public function __construct(Builder $query)
        {
            $this->query = $query;
            $this->columns = new Collection();

            try {
                $this->request = Container::getInstance()->make('request');
            } catch (BindingResolutionException $e) {
                // TODO Do something here
            }
        }

        /**
         * @param Builder $query
         * @return DataTable
         */
        public static function create(Builder $query): DataTable
        {
            return new static($query);
        }

        /**
         * @param Column $column
         * @return DataTable
         */
        public function addColumn(Column $column): DataTable
        {
            $this->columns->push($column);

            return $this;
        }

        /**
         * @param array $columns
         * @return DataTable
         */
        public function setColumns(array $columns): DataTable
        {
            $this->columns = new Collection($columns);

            return $this;
        }

        private function addSearchToQuery()
        {
            $this->query = WhereQueryBuilder::create(
                $this->query,
                $this->columns,
                $this->request->query('search')
            )->build();
        }

        private function addSortingToQuery()
        {
            $this->query = OrderQueryBuilder::create(
                $this->query,
                $this->columns,
                $this->request->query('sorting')
            )->build();
        }

        /**
         * @param string $recourseClass
         * @return AnonymousResourceCollection
         */
        public function get(string $recourseClass): AnonymousResourceCollection
        {
            $page = $this->request->query('page', 1);
            $perPage = $this->request->query('itemPerPage', 10);

            if ($this->request->query->has('search')) {
                $this->addSearchToQuery();
            }

            if ($this->request->query->has('sorting')) {
                $this->addSortingToQuery();
            }

            $total = $this->query->count();
            $data = $this->query->skip(($page - 1) * $perPage)->take($perPage)->get();

            return call_user_func([$recourseClass, "collection"], $data)->additional([
                'meta' => [
                    'total' => $total
                ]
            ]);
        }
    }
