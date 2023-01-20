<?php

namespace App\Company\Cms\Resources;

use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Models\CmsFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CmsFile
 */
class CmsTableItemFileResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            CmsFileTableMap::COL_ID => $this->id,
            CmsFileTableMap::COL_NAME => $this->name,
            CmsFileTableMap::COL_SIZE => $this->size,
            CmsFileTableMap::COL_TYPE => $this->type,
        ];
    }
}
