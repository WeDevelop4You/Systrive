<?php

    namespace App\Company\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserCreateResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'email' => '',
                'roles' => [],
                'permissions' => [],
            ];
        }
    }
