<?php

    namespace App\Admin\Translation\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class TranslationKeyDataResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray(Request $request): array
        {
            return [
                'id' => $this->id,
                'key' => $this->key,
                'group' => $this->group,
                'tags' => array_map('ucfirst', $this->tags->toArray()),
                'translated' => $this->translations->pluck('locale')->toArray(),
            ];
        }
    }
