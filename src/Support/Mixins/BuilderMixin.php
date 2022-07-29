<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Support\Helpers\DataTable\Build\Paginator;

/**
 * @mixin Builder
 */
class BuilderMixin
{
    /**
     * @return Closure
     */
    public function fastPaginate(): Closure
    {
        /**
         * @param int $perPage
         * @param int $page
         *
         * @return Paginator
         */
        return function (int $perPage = 10, int $page = 1): Paginator {
            $model = $this->newModelInstance();
            $key = $model->getKeyName();
            $table = $model->getTable();

            $paginator = $this->clone()
                ->select(["$table.$key"])
                ->setEagerLoads([])
                ->paginate($perPage, ['*'], 'page', $page);
            $ids = $paginator->getCollection()->map->getRawOriginal($key)->toArray();

            $this->query->wheres[] = [
                'type' => 'InRaw',
                'column' => "$table.$key",
                'values' => $ids,
                'boolean' => 'and',
            ];

            return new Paginator(
                $paginator->total(),
                $this->get()
            );
        };
    }
}
