<?php

    namespace App\Admin\Company\Role\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyRoleResource extends JsonResource
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
                'permissions' => $this->permissions()?->pluck('id')->toArray() ?: [],
            ];
        }
    }
