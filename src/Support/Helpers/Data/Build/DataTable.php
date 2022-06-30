<?php

    namespace Support\Helpers\Data\Build;

    use Illuminate\Container\Container;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Database\Query\Builder as QueryBuilder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\App;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Queries\OrderQueryBuilder;
    use Support\Helpers\Data\Queries\WhereQueryBuilder;
    use Support\Response\Components\AbstractComponent;
    use Support\Response\Response;

    class DataTable
    {
        /**
         * @var int
         */
        private int $total = -1;

        /**
         * @var int
         */
        public int $totalSkip = 0;

        /**
         * @var int
         */
        public int $perPage;

        /**
         * @var Collection
         */
        private Collection $items;

        /**
         * @var EloquentBuilder|Relation
         */
        private EloquentBuilder|Relation $query;

        /**
         * @var Request
         */
        private Request $request;

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
            //
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
         * @param EloquentBuilder|QueryBuilder|Relation $query
         *
         * @return DataTable
         */
        public function query(Relation|EloquentBuilder|QueryBuilder $query): DataTable
        {
            $this->query = $query;

            try {
                $this->request = Container::getInstance()->make('request');

                $pages = $this->request->query('page', 1);
                $perPage = $this->request->query('itemPerPage', 10);

                $this->perPage = $perPage;
                $this->totalSkip = ($pages - 1) * $perPage;
            } catch (BindingResolutionException) {
                //Do nothing
            }

            return $this;
        }

        public function withoutQuery(Collection $items): DataTable
        {
            $this->items = $items;
            $this->withoutQuery = true;

            return $this;
        }

        private function addSearchToQuery(): void
        {
            $this->query = WhereQueryBuilder::create(
                $this->query,
                $this->table->getColumns(),
                $this->request->query('search')
            )->build();
        }

        private function addSortingToQuery(): void
        {
            $this->query = OrderQueryBuilder::create(
                $this->query,
                $this->table->getColumns(),
                $this->request->query('sorting')
            )->build();
        }

        private function runQuery(): void
        {
            if ($this->request->query->has('search')) {
                $this->addSearchToQuery();
            }

            if ($this->request->query->has('sorting')) {
                $this->addSortingToQuery();
            }

            $this->total = $this->query->count();
            $this->items = $this->query->skip($this->totalSkip)->take($this->perPage)->get();
        }

        /**
         * @return array
         */
        private function itemProcess(): array
        {
            $columns = $this->table->getColumns();
            $index = $this->withoutQuery ? $this->totalSkip : 0;

            return $this->items->map(function ($data) use ($columns, &$index) {
                $index++;

                return $columns->mapWithKeys(function (Column $column) use ($data, &$index) {
                    $key = $column->getKey();

                    if ($column->hasFormat) {
                        $value = $this->createFormatData(
                            $column->getFormatCallback(),
                            ['key' => $key, 'data' => $data, 'index' => $index]
                        );
                    } elseif ($data instanceof Model) {
                        $value = $this->createModalData($key, $data);
                    } else {
                        $value = Arr::get($data, $key);
                    }

                    if (is_null($value)) {
                        $value = '';
                    }

                    return [$column->identifier => $value];
                })->toArray();
            })->values()->toArray();
        }

        /**
         * @param callable $callback
         * @param array    $arguments
         *
         * @return array|mixed
         */
        private function createFormatData(callable $callback, array $arguments): mixed
        {
            $format = App::call($callback, $arguments);

            if ($format instanceof AbstractComponent) {
                return $format->export();
            }

            return $format;
        }

        /**
         * @param string $dotKey
         * @param Model  $model
         *
         * @return mixed
         */
        private function createModalData(string $dotKey, Model $model): mixed
        {
            foreach (explode('.', $dotKey) as $key) {
                $model = $model?->getAttribute($key);
            }

            return $model;
        }

        /**
         * @return JsonResponse
         */
        public function export(): JsonResponse
        {
            if (!$this->withoutQuery) {
                $this->runQuery();
            }

            return Response::create()->addData([
                'items' => $this->itemProcess(),
                'meta' => [
                    'total' => $this->total,
                ],
            ])->toJson();
        }
    }
