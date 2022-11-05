<?php

namespace App\Admin\Cms\Resources;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Company\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CmsCreateResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            CmsTableMap::NAME => null,
            CmsTableMap::DATABASE => null,
            CmsTableMap::USERNAME => null,
            CmsTableMap::PASSWORD => null,
            'system' => $this->system->username,
        ];
    }
}
