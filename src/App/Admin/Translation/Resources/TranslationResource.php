<?php

namespace App\Admin\Translation\Resources;

use Domain\Translation\Models\TranslationKey;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use WeDevelop4You\TranslationFinder\Models\Translation;

/**
 * @mixin TranslationKey
 */
class TranslationResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'translations' => $this->translations->mapWithKeys(function (Translation $translation) {
                return  [$translation->locale => [
                    'locale' => $translation->locale,
                    'translation' => $translation->translation,
                ]];
            }),
        ];
    }
}
