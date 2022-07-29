<?php

    namespace App\Admin\Permission\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class PermissionResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            [$group, $permission] = explode('.', $this->name, 2);

            $name = "permission.{$permission}";

            return [
                'id' => $this->id,
                'name' => trans($name),
            ];
        }
    }
