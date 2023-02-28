<?php

namespace Domain\Cms\Collections;

use Domain\Cms\Graphql\Mutations\CmsCreateMutation;
use Domain\Cms\Graphql\Mutations\CmsDeleteMutation;
use Domain\Cms\Graphql\Mutations\CmsUpdateMutation;
use Domain\Cms\Graphql\Queries\CmsItemQuery;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

class CmsTableCollection extends Collection
{
    /**
     * @return CmsTableCollection|BaseCollection
     */
    public function createGraphqlQuery(): BaseCollection|CmsTableCollection
    {
        return $this->whereQueryable()->map(
            fn (CmsTable $table) => CmsItemQuery::create($table)
        );
    }

    /**
     * @return BaseCollection
     */
    public function createGraphqlMutation(): BaseCollection
    {
        $mutation = $this->whereMutable();

        $createMutation = $mutation->map(
            fn (CmsTable $table) => CmsCreateMutation::create($table)
        )->filter();

        $updateMutation = $mutation->map(
            fn (CmsTable $table) => CmsUpdateMutation::create($table)
        )->filter();

        $deleteMutation = $this->whereTable()->whereDeletable()->map(
            fn (CmsTable $table) => CmsDeleteMutation::create($table)
        );

        return BaseCollection::make($createMutation)
            ->merge($updateMutation)
            ->merge($deleteMutation);
    }

    /**
     * @return CmsTableCollection
     */
    public function whereTable(): CmsTableCollection
    {
        return $this->where(CmsTableTableMap::COL_IS_TABLE, true);
    }

    /**
     * @return CmsTableCollection
     */
    public function whereQueryable(): CmsTableCollection
    {
        return $this->where(CmsTableTableMap::COL_QUERYABLE, true);
    }

    /**
     * @return CmsTableCollection
     */
    public function whereMutable(): CmsTableCollection
    {
        return $this->where(CmsTableTableMap::COL_MUTABLE, true);
    }

    /**
     * @return CmsTableCollection
     */
    public function whereDeletable(): CmsTableCollection
    {
        return $this->where(CmsTableTableMap::COL_DELETABLE, true);
    }
}
