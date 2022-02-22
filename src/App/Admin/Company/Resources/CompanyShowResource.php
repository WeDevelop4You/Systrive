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
                'system_id' => $this->system?->id,
                'list_details' => $this->mergeWhen(!is_null($this?->listDetails), $this->listDetails),
            ];
        }
    }
