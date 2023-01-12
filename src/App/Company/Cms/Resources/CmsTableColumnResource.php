<?php

namespace App\Company\Cms\Resources;

use ArrayObject;
use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CmsColumn
 */
class CmsTableColumnResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $properties = $this->properties->mapWithKeys(function (AbstractColumnOption $option) {
            return [$option->getKey() => $option->getValue()];
        })->toArray();

        return [
            CmsColumnTableMap::COL_KEY => $this->key,
            CmsColumnTableMap::COL_AFTER => 'default',
            CmsColumnTableMap::COL_LABEL => $this->label,
            CmsColumnTableMap::COL_ORIGINAL_KEY => $this->key,
            CmsColumnTableMap::COL_TYPE => $this->type?->value,
            CmsColumnTableMap::COL_HIDDEN => $this->hidden ?? false,
            CmsColumnTableMap::COL_EDITABLE => $this->editable ?? true,
            CmsColumnTableMap::COL_DELETABLE => $this->deletable,
            CmsColumnTableMap::COL_PROPERTIES => $properties ?: new ArrayObject(),
        ];
    }
}
