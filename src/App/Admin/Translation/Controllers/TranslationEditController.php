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
    use WeDevelop4You\TranslationFinder\Classes\Manager;
    use WeDevelop4You\TranslationFinder\Exceptions\FailedToBuildTranslationFileException;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationEditController extends Controller
    {
        /**
         * @param TranslationKey $translationKey
         * @return JsonResponse
         */
        public function index(TranslationKey $translationKey): JsonResponse
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
        public function action(TranslationUpdateRequests $request, TranslationKey $translationKey): JsonResponse
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
    }
