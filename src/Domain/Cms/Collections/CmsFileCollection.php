<?php

namespace Domain\Cms\Collections;

use Domain\Cms\Mappings\CmsFileTableMap;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionBase;

class CmsFileCollection extends Collection
{
    /**
     * @param string $key
     *
     * @return CollectionBase
     */
    public function column(string $key): CollectionBase
    {
        return $this->where(CmsFileTableMap::COL_TABLE_KEY, $key);
    }
}
