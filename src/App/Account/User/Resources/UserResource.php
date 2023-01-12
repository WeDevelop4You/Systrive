<?php

namespace App\Account\User\Resources;

use Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'email' => $this->email,
            'full_name' => $this->full_name,
        ];
    }
}
