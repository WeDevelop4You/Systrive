<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'email' => $this->email,
                'first_name' => $this->profile?->first_name,
                'middle_name' => $this->profile?->middle_name,
                'last_name' => $this->profile?->last_name,
                'full_name' => $this->full_name,
                'birth_date' => $this->profile?->birth_date?->toDateString(),
                'gender' => $this->profile?->gender,
            ];
        }
    }
