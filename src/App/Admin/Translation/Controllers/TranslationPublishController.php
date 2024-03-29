<?php

namespace App\Admin\Translation\Controllers;

use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use WeDevelop4You\TranslationFinder\Classes\Manager;
use WeDevelop4You\TranslationFinder\Exceptions\FailedToBuildTranslationFileException;

class TranslationPublishController
{
    /**
     * @return JsonResponse
     *
     * @throws FailedToBuildTranslationFileException
     */
    public function action(): JsonResponse
    {
        Manager::publishAll();

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.publish.translations')))
            ->toJson();
    }
}
