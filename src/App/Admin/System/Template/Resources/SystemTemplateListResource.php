<?php

    namespace App\Admin\System\Template\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class SystemTemplateListResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'value' => $this->value,
                'text' => $this->name,
            ];
        }
    }
