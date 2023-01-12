<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Requests\CompanyInviteRequest;
use App\Admin\Company\Responses\CompanyInviteResponse;
use Domain\Company\Actions\CompanyInviteAction;
use Domain\Company\DataTransferObjects\CompanyInviteData;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CompanyInviteController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return CompanyInviteResponse::create()->toJson();
    }

    /**
     * @param CompanyInviteRequest $requests
     *
     * @return JsonResponse
     */
    public function action(CompanyInviteRequest $requests): JsonResponse
    {
        $data = new CompanyInviteData(...$requests->validated());

        (new CompanyInviteAction())($data);

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
            ->setStatusCode(ResponseCode::HTTP_CREATED)
            ->toJson();
    }
}
