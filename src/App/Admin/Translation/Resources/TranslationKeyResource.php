<?php

    namespace App\Admin\Translation\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Illuminate\Support\Collection;
    use Support\Response\Components\Items\ItemGroupBadgesComponent;
    use WeDevelop4You\TranslationFinder\Models\Translation;

    class TranslationKeyResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            $tags = ItemGroupBadgesComponent::create()
                ->convertArray(
                    $this->tags
                    ->map(fn (string $value) => ucfirst($value))
                    ->toArray()
                )
                ->export();

            return [
                'id' => $this->id,
                'key' => $this->key,
                'group' => $this->group,
                'environment' => $this->environment,
                'tags' => $tags,
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
