<?php

    namespace Support\Helpers\DataTable\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\DataTable\Queries\OrderQueryBuilder;
    use Support\Helpers\DataTable\Queries\WhereQueryBuilder;
    use Support\Response\Response;

    class DataTable
    {
        /**
         * @var int
         */
        private int $total = -1;

        /**
         * @var Collection
         */
        private Collection $items;

        /**
         * @var Request
         */
        private Request $request;

        /**
         * @var Builder|EloquentBuilder|Relation
         */
        private EloquentBuilder|Relation|Builder $query;

        /**
         * @var bool
         */
        private bool $withoutQuery = false;

        /**
         * DataTable constructor.
         *
         * @param AbstractTable $table
         */
        private function __construct(
            private readonly AbstractTable $table
        ) {
            try {
                $this->request = Container::getInstance()->make('request');
            } catch (BindingResolutionException) {
                //Do nothing
            }
        }

        /**
         * @param AbstractTable $table
         *
         * @return DataTable
         */
        public static function create(AbstractTable $table): DataTable
        {
            return new static($table);
        }

        /**
         * @param Builder|EloquentBuilder|Relation $query
         *
         * @return DataTable
         */
        public function query(Relation|Builder|EloquentBuilder $query): DataTable
        {
            $this->query = $query;

            return $this;
        }

        public function withoutQuery(Collection $items): DataTable
        {
            $this->items = $items;
            $this->withoutQuery = true;

            return $this;
        }

        private function paginate(): void
        {
            $page = $this->request->query('page', 1);
            $perPage = $this->request->query('itemPerPage', 10);
            $paginator = $this->createQuery()->fastPaginate($perPage, $page);

            $this->total = $paginator->total();
            $this->items = $paginator->items();
        }

        /**
         * @return Builder|EloquentBuilder|Relation
         */
        private function createQuery(): EloquentBuilder|Relation|Builder
        {
            if ($this->request->query->has('search')) {
                $this->query = WhereQueryBuilder::create(
                    $this->query,
                    $this->table->getColumns(),
                    $this->request->query('search', '')
                );
            }

            if ($this->request->query->has('sorting')) {
                $this->query = OrderQueryBuilder::create(
                    $this->query,
                    $this->table->getColumns(),
                    $this->request->query('sorting')
                );
            }

            return $this->query;
        }

        /**
         * @return JsonResponse
         */
        public function export(): JsonResponse
        {
            if (!$this->withoutQuery) {
                $this->paginate();
            }

            $items = Rows::create(
                $this->items,
                $this->table->getColumns(),
                $this->request
            );

            return Response::create()->addData([
                'items' => $items,
                'meta' => [
                    'total' => $this->total,
                ],
            ])->toJson();
        }
    }
