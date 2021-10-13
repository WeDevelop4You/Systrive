<?php

    namespace App\Admin\Translation\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationKeyResource extends JsonResource
    {
        /**
         * @param Request $request
         * @return array
         */
        public function toArray($request): array
        {
            return [
                'id' => $this->id,
                'key' => $this->key,
                'group' => $this->group,
                'tags' => array_map('ucfirst', $this->tags->toArray()),
                'sources' => $this->sources->pluck('source')->toArray(),
                'translations' => $this->createLocalesList(),
            ];
        }

        /**
         * @return array
         */
        private function createLocalesList(): array
        {
            $translations = TranslationKey::find(1)->translations;

            return Collection::make(['en', 'nl'])->map(function (string $locale) use ($translations) {
                $translation = $translations->firstWhere('locale', $locale);

                if (is_null($translation)) {
                    $translation = new Translation();
                    $translation->locale = $locale;
                }

                return TranslationResource::make($translation);
            })->toArray();
        }
    }
