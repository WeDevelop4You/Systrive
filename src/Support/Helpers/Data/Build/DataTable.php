<?php

    namespace Support\Helpers\Data\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Helpers\Data\Queries\OrderQueryBuilder;
    use Support\Helpers\Data\Queries\WhereQueryBuilder;

    class DataTable
    {
        /**
         * @var Builder|Relation
         */
        private Builder|Relation $query;

        /**
         * @var Request
         */
        private Request $request;

        /**
         * @var Collection|Column[]
         */
        private Collection|array $columns;

        /**
         * @param Relation|Builder $query
         */
        public function __construct(Relation|Builder $query)
        {
            $this->query = $query;
            $this->columns = new Collection();

            try {
                $this->request = Container::getInstance()->make('request');
            } catch (BindingResolutionException) {
                // TODO Do something here
            }
        }

        /**
         * @param Builder|Relation $query
         *
         * @return DataTable
         */
        public static function create(Relation|Builder $query): DataTable
        {
            return new static($query);
        }

        /**
         * @param Column $column
         *
         * @return DataTable
         */
        public function addColumn(Column $column): DataTable
        {
            $this->columns->push($column);

            return $this;
        }

        /**
         * @param array $columns
         *
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
         * @param string $resourceClass
         *
         * @return AnonymousResourceCollection
         */
        public function getData(string $resourceClass): AnonymousResourceCollection
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

            return call_user_func([$resourceClass, "collection"], $data)->additional([
                'meta' => [
                    'total' => $total,
                ],
            ]);
        }
    }
