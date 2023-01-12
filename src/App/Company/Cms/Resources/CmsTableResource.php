<?php

namespace App\Company\Cms\Resources;

use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CmsTable
 */
class CmsTableResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            CmsTableTableMap::COL_LABEL => $this->label,
            CmsTableTableMap::COL_NAME => $this->name,
            CmsTableTableMap::COL_EDITABLE => $this->editable ?: true,
        ];
    }
}
