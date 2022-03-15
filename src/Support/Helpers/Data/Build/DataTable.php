<?php

    namespace Support\Helpers\Data\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Queries\OrderQueryBuilder;
    use Support\Helpers\Data\Queries\WhereQueryBuilder;

    class DataTable
    {
        /**
         * @var int
         */
        private int $total = -1;

        /**
         * @var array|Collection
         */
        private Collection|array $items;

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
         * @var bool
         */
        private bool $withoutQuery = false;

        /**
         * DataTable constructor.
         */
        private function __construct()
        {
            $this->columns = new Collection();
        }

        /**
         * @param Builder|Relation $query
         *
         * @return DataTable
         */
        public static function query(Relation|Builder $query): DataTable
        {
            $instance = new static();
            $instance->query = $query;

            try {
                $instance->request = Container::getInstance()->make('request');
            } catch (BindingResolutionException) {
                //Do nothing
            }

            return $instance;
        }

        public static function withoutQuery(Collection|array $items): DataTable
        {
            $instance = new static();
            $instance->items = $items;
            $instance->withoutQuery = true;

            return $instance;
        }

        /**
         * @param AbstractTable $table
         *
         * @return DataTable
         */
        public function setColumns(AbstractTable $table): DataTable
        {
            $this->columns = $table->getColumns();

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

        private function runQuery()
        {
            $page = $this->request->query('page', 1);
            $perPage = $this->request->query('itemPerPage', 10);

            if ($this->request->query->has('search')) {
                $this->addSearchToQuery();
            }

            if ($this->request->query->has('sorting')) {
                $this->addSortingToQuery();
            }

            $this->total = $this->query->count();
            $this->items = $this->query->skip(($page - 1) * $perPage)->take($perPage)->get();
        }

        /**
         * @param string $resourceClass
         *
         * @return AnonymousResourceCollection
         */
        public function export(string $resourceClass): AnonymousResourceCollection
        {
            if (!$this->withoutQuery) {
                $this->runQuery();
            }

            return call_user_func([$resourceClass, "collection"], $this->items)->additional([
                'meta' => [
                    'total' => $this->total,
                ],
            ]);
        }
    }
