<?php

namespace App\Admin\Cms\Resources;

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
            CmsTableTableMap::LABEL => $this->label,
            CmsTableTableMap::NAME => $this->name,
            CmsTableTableMap::EDITABLE => $this->editable ?: true,
        ];
    }
}
