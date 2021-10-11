<?php

    namespace App\Admin\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class UserProfileResource extends JsonResource
    {
        /**
         * @param Request $request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'full_name' => $this->full_name,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date->toDateString(),
                'bio' => $this->bio,
            ];
        }
    }
