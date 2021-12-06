<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Requests\TranslationUpdateRequests;
    use App\Admin\Translation\Resources\TranslationKeyResource;

    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Collection;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationEditController
    {
        /**
         * @param TranslationKey $translationKey
         *
         * @return JsonResponse
         */
        public function index(TranslationKey $translationKey): JsonResponse
        {
            $response = Response::create();
            $response->addData(TranslationKeyResource::make($translationKey));

            return $response->toJson();
        }

        /**
         * @param TranslationUpdateRequests $request
         * @param TranslationKey            $translationKey
         *
         * @return JsonResponse
         */
        public function action(TranslationUpdateRequests $request, TranslationKey $translationKey): JsonResponse
        {
            $validated = (object) $request->validated();

            Collection::make($validated->translations)
                ->each(function (array $translationData) use ($translationKey) {
                    $translationData = (object) $translationData;

                    if (!is_null($translationData->translation)) {
                        $translation = $translationKey->translations()->where('locale', $translationData->locale)->firstOrNew();

                        $translation->locale = $translationData->locale;
                        $translation->translation = $translationData->translation;

                        $translation->isDirty()
                            ? $translation->save()
                            : null;
                    }
                });

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.update.translation')))
                ->toJson();
        }
    }
