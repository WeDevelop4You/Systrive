<?php

    namespace App\Admin\Company\User\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyUserDataResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                'email' => $this->email,
                'profile' => [
                    'full_name' => $this->full_name,
                ],
            ];
        }
    }
