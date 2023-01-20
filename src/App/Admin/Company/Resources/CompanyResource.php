<?php

namespace App\Admin\Company\Resources;

use Domain\Company\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'domain' => $this->domain,
            'owner' => $this->owner?->id,
            'modules' => CompanyModuleResource::make($this->modules),
        ];
    }
}
