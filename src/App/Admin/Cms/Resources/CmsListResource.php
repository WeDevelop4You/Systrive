<?php

namespace App\Admin\Cms\Resources;

use Domain\Cms\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin Cms
 */
class CmsListResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'value' => $this->id,
            'text' => Str::after($this->username->decryptString(), '_'),
        ];
    }
}
