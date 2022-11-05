<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\Responses\CmsDestroyResponse;
use Domain\Cms\Actions\CmsDestroyAction;
use Domain\Cms\Actions\CmsRestoreAction;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class CmsRestoreController
{
    public function action(Company $company, Cms $cms): JsonResponse
    {
        $successFull = (new CmsRestoreAction())($cms);

        if ($successFull) {
            return Response::create()->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.restored')),
            )->toJson();
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.restored')),
            \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
        )->toJson();
    }
}
