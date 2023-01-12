<?php

namespace App\Admin\Cms\Resources;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Cms\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Cms
 */
class CmsResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            CmsTableMap::COL_ID => $this->id,
            CmsTableMap::COL_NAME => $this->name,
            CmsTableMap::COL_DATABASE => $this->database,
        ];
    }
}
