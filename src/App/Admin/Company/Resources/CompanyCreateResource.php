<?php

    namespace App\Admin\Company\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyCreateResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'name' => null,
                'owner' => null,
            ];
        }
    }
