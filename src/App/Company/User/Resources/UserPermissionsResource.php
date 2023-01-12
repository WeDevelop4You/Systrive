<?php

    namespace App\Company\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserPermissionsResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return $this->getAllPermissions()->pluck('name')->toArray();
        }
    }
