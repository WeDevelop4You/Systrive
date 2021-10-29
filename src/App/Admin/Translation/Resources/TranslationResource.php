<?php

    namespace App\Admin\Translation\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class TranslationResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray(Request $request): array
        {
            return [
                'locale' => $this->locale,
                'translation' => $this->translation,
            ];
        }
    }
