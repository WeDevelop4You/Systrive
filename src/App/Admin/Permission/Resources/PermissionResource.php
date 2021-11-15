<?php

    namespace App\Admin\Permission\Resources;

    use App\Admin\User\Resources\UserListResource;
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

            return [
                'id' => $this->id,
                'name' => sprintf('$vuetify.permission.%s', $permission),
            ];
        }
    }
