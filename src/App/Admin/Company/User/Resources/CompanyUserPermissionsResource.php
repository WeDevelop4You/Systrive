<?php

    namespace App\Admin\Company\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyUserPermissionsResource extends JsonResource
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
