<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserResource extends JsonResource
    {
        /**
         * @param Request $request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'email' => $this->email,
                'email_verified_at' => $this->email_verified_at->toDatetimeString(),
            ];
        }
    }
