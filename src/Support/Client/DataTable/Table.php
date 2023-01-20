<?php

namespace Support\Client\DataTable;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request as RequestFacades;
use Support\Abstracts\AbstractTable;
use Support\Client\DataTable\Build\Rows;
use Support\Client\DataTable\Queries\OrderQueryBuilder;
use Support\Client\DataTable\Queries\WhereQueryBuilder;
use Support\Client\Response;

class Table
{
    /**
     * @var int
     */
    private int $total = -1;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Collection
     */
    private Collection $items;

    /**
     * @var Collection
     */
    private Collection $columns;

    /**
     * @var bool
     */
    private bool $withoutQuery = false;

    /**
     * @var Builder|EloquentBuilder|Relation
     */
    private EloquentBuilder|Relation|Builder $query;

    /**
     * DataTable constructor.
     *
     * @param AbstractTable $table
     */
    private function __construct(AbstractTable $table)
    {
        $this->columns = $table->getColumns();
        $this->request = RequestFacades::instance();
    }

    /**
     * @param AbstractTable $table
     *
     * @return Table
     */
    public static function create(AbstractTable $table): Table
    {
        return new static($table);
    }

    /**
     * @param Builder|EloquentBuilder|Relation $query
     *
     * @return Table
     */
    public function query(Relation|Builder|EloquentBuilder $query): Table
    {
        $this->query = $query;

        return $this;
    }

    public function withoutQuery(Collection $items): Table
    {
        $this->items = $items;
        $this->withoutQuery = true;

        return $this;
    }

    private function paginate(): void
    {
        $page = $this->request->query('page', 1);
        $perPage = $this->request->query('itemsPerPage', 10);
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
                $this->columns,
                $this->request->query('search', '')
            );
        }

        if ($this->request->query->has('sorting')) {
            $this->query = OrderQueryBuilder::create(
                $this->query,
                $this->columns,
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
        if (! $this->withoutQuery) {
            $this->paginate();
        }

        $items = Rows::create(
            $this->items,
            $this->columns,
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
