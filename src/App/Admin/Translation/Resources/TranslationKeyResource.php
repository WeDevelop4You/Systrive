<?php

    namespace App\Admin\Translation\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;
    use WeDevelop4You\TranslationFinder\Models\Translation;

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
                'environment' => $this->environment,
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
            $translations = $this->translations;
            $locales = config('translation.locales');

            return Collection::make($locales)->map(function (string $locale) use ($translations) {
                $translation = $translations->firstWhere('locale', $locale);

                if (is_null($translation)) {
                    $translation = new Translation();
                    $translation->locale = $locale;
                }

                return TranslationResource::make($translation);
            })->toArray();
        }
    }
