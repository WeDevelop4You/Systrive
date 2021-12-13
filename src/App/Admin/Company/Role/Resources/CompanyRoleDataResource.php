<?php

    namespace App\Admin\Company\Role\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyRoleDataResource extends JsonResource
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
                'permissions_count' => $this->permissions_count,
                'created_at' => $this->created_at->toDatetimeString(),
            ];
        }
    }
