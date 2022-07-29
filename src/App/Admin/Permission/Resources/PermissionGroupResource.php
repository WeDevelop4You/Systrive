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
            $name = "word.{$this->group}.{$this->group}";

            return [
                'id' => $this->id,
                'type' => $this->group,
                'name' => trans($name),
                'permissions' => PermissionResource::collection($this->permissions),
            ];
        }
    }
