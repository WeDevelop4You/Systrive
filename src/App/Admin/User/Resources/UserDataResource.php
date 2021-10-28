<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserDataResource extends JsonResource
    {
        /**
         * @param Request $request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                'email' => $this->email,
                'email_verified_at' => $this->email_verified_at->toDatetimeString(),
                'created_at' => $this->created_at->toDatetimeString(),
                'deleted_at' => $this->deleted_at ? $this->deleted_at->toDatetimeString() : null,
                'profile' => [
                    'full_name' => $this->full_name
                ],
            ];
        }
    }
