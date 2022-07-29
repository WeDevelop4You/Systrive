<?php

namespace Support\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HigherOrderTapProxy;

/**
 * @mixin Relation
 */
class RelationMixin
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
         * @return HigherOrderTapProxy|mixed
         */
        return function (int $perPage = 10, int $page = 1) {
            if ($this instanceof HasManyThrough || $this instanceof BelongsToMany) {
                $this->query->addSelect($this->shouldSelect());
            }

            return tap($this->query->fastPaginate($perPage, $page), function ($paginator) {
                if ($this instanceof BelongsToMany) {
                    $this->hydratePivotRelation($paginator->items()->all());
                }
            });
        };
    }
}
