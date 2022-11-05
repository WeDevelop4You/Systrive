<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\Responses\CmsDestroyResponse;
use Domain\Cms\Actions\CmsDestroyAction;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class CmsDestroyController
{
    /**
     * @param Company $company
     * @param Cms     $cms
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms): JsonResponse
    {
        return CmsDestroyResponse::create($company, $cms)->toJson();
    }

    public function action(Company $company, Cms $cms): JsonResponse
    {
        $successFull = (new CmsDestroyAction())($cms);

        if ($successFull) {
            return Response::create()->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.deleted')),
            )->toJson();
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.deleted')),
            \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST
        )->toJson();
    }
}
