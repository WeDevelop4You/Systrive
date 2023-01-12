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
            CmsTableMap::COL_NAME => null,
            CmsTableMap::COL_DATABASE => null,
            CmsTableMap::COL_USERNAME => null,
            CmsTableMap::COL_PASSWORD => null,
            'system' => $this->system->username,
        ];
    }
}
