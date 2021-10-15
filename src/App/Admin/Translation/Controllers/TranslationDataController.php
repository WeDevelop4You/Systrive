<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Requests\TranslationUpdateRequests;
    use App\Admin\Translation\Resources\TranslationKeyDataResource;
    use App\Admin\Translation\Resources\TranslationKeyResource;
    use App\Controller;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Table\Build\Column;
    use Support\Helpers\Table\Build\DataTable;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationDataController extends Controller
    {
        /**
         * @param string $environment
         * @return AnonymousResourceCollection
         */
        public function index(string $environment): AnonymousResourceCollection
        {
            $columns = [
                Column::create('key')->sortable()->searchable(),
                Column::create('group')->sortable()->searchable(),
                Column::create('tags')->sortable()->searchable(),
                Column::create('translated')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(Translation::selectRaw('MAX(locale)')->whereColumn('translation_keys.id', 'translations.translation_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('translations', function (Builder $query) use ($search) {
                        return $query->where('locale', 'like', "%{$search}%");
                    });
                }),
            ];

            return DataTable::create(TranslationKey::whereEnvironment($environment))->setColumns($columns)->get(TranslationKeyDataResource::class);
        }

        /**
         * @return JsonResponse
         */
        public function environments(): JsonResponse
        {
            return response()->json([
                'data' => TranslationKey::select('environment')
                    ->distinct()
                    ->pluck('environment')
                    ->toArray()
                ]);
        }

        /**
         * @param TranslationKey $translationKey
         * @return JsonResponse
         */
        public function edit(TranslationKey $translationKey): JsonResponse
        {
            $response = Response::create();
            $response->addData($translationKey, TranslationKeyResource::class);

            return $response->toJson();
        }

        /**
         * @param TranslationUpdateRequests $request
         * @param TranslationKey $translationKey
         * @return JsonResponse
         */
        public function update(TranslationUpdateRequests $request, TranslationKey $translationKey): JsonResponse
        {
            $validated = (object) $request->validated();

            Collection::make($validated->translations)
                ->each(function (array $translationData) use ($translationKey) {
                    $translationData = (object) $translationData;

                    $translation = $translationKey->translations()->where('locale', $translationData->locale)->firstOrNew();

                    $translation->locale = $translationData->locale;
                    $translation->translation = $translationData->translation;

                    $translation->isDirty()
                        ? $translation->save()
                        : null;
                });

            $response = new Response();
            $response->addPopup(trans('response.success.update.translation'));

            return $response->toJson();
        }

        /**
         * @param TranslationKey $translationKey
         * @return JsonResponse
         */
        public function destroy(TranslationKey $translationKey): JsonResponse
        {
            $translationKey->delete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.translation'));

            return $response->toJson();
        }
    }
