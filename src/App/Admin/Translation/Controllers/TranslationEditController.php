<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Requests\TranslationUpdateRequest;
    use App\Admin\Translation\Responses\TranslationEditResponse;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Collection;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
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
            return TranslationEditResponse::create($translationKey)->toJson();
        }

        /**
         * @param TranslationUpdateRequest $request
         * @param TranslationKey           $translationKey
         *
         * @return JsonResponse
         */
        public function action(TranslationUpdateRequest $request, TranslationKey $translationKey): JsonResponse
        {
            $validated = (object) $request->validated();

            Collection::make($validated->translations)
                ->each(function (array $translationData) use ($translationKey) {
                    $translationData = (object) $translationData;

                    if (!\is_null($translationData->translation)) {
                        $translation = $translationKey->translations()->where('locale', $translationData->locale)->firstOrNew();

                        $translation->locale = $translationData->locale;
                        $translation->translation = $translationData->translation;

                        $translation->isDirty()
                            ? $translation->save()
                            : null;
                    }
                });

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
