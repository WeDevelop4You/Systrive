<?php

    namespace App\Admin\Company\User\Resources;

    use App\Admin\Company\Role\Resources\RoleListResource;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyUserResource extends JsonResource
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
                'permissions' => $this->permissions()->pluck('id')
            ];
        }
    }
