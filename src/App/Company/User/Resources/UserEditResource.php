<?php

namespace App\Company\User\Resources;

use App\Company\Role\Resources\RoleListResource;
use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserEditResource extends JsonResource
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
            'roles' => RoleListResource::collection($this->roles),
            'permissions' => $this->permissions->pluck('id'),
        ];
    }
}
