<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserListResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray(Request $request): array
        {
            return [
                'id' => $this->id,
                'email' => $this->email,
                'full_name' => $this->full_name,
            ];
        }
    }
