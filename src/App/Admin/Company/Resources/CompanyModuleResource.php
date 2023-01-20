<?php

namespace App\Admin\Company\Resources;

use Domain\Company\Enums\CompanyModuleTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class CompanyModuleResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Collection $this */
        return $this->map(function ($value, $module) {
            return [
                'title' => CompanyModuleTypes::from($module)->trans(),
                'value' => $value,
            ];
        })->toArray();
    }
}
