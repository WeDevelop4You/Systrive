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
            CmsTableMap::ID => $this->id,
            CmsTableMap::NAME => $this->name,
            CmsTableMap::DATABASE => $this->database,
        ];
    }
}
