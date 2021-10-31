<?php

    namespace Support\Helpers\Data\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Helpers\Data\Queries\WhereQueryBuilder;

    class DataList
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

        public function __construct(Builder $query, string $columnName)
        {
            $this->query = $query->orderBy($columnName);

            $this->columns = new Collection([
                Column::create($columnName)->searchable(),
            ]);

            try {
                $this->request = Container::getInstance()->make('request');
            } catch (BindingResolutionException $e) {
                // TODO Do something here
            }
        }

        /**
         * @param Builder $query
         * @param string  $columnName
         *
         * @return DataList
         */
        public static function create(Builder $query, string $columnName): DataList
        {
            return new static($query, $columnName);
        }

        private function addSearchToQuery()
        {
            $this->query = WhereQueryBuilder::create(
                $this->query,
                $this->columns,
                $this->request->query('search')
            )->build();
        }

        /**
         * @param string $resourceClass
         *
         * @return AnonymousResourceCollection
         */
        public function get(string $resourceClass): AnonymousResourceCollection
        {
            if ($this->request->query->has('search')) {
                $this->addSearchToQuery();
            }

            $data = $this->query->take(10)->get();

            return call_user_func([$resourceClass, "collection"], $data);
        }
    }
