<?php

    namespace App\Admin\Company\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class CompanyShowResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->email,
                'domain' => $this->domain,
                'information' => $this->information,
                'system_id' => $this->system?->id,
            ];
        }
    }
