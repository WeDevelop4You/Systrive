<?php

    namespace App\Admin\Permission\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class PermissionGroupResource extends JsonResource
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
                'type' => $this->group,
                'name' => translateToVuetify("word.{$this->group}.{$this->group}"),
                'permissions' => PermissionResource::collection($this->permissions),
            ];
        }
    }
