<?php

namespace App\Admin\Cms\Resources;

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
            CmsColumnTableMap::KEY => $this->key,
            CmsColumnTableMap::AFTER => 'default',
            CmsColumnTableMap::LABEL => $this->label,
            CmsColumnTableMap::ORIGINAL_KEY => $this->key,
            CmsColumnTableMap::TYPE => $this->type?->value,
            CmsColumnTableMap::EDITABLE => $this->editable ?? true,
            CmsColumnTableMap::DELETABLE => $this->deletable,
            CmsColumnTableMap::PROPERTIES => $properties ?: new ArrayObject(),
        ];
    }
}
