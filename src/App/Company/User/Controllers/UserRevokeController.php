<?php

namespace App\Company\User\Controllers;

use App\Company\User\Responses\UserRevokeConfirmResponse;
use Domain\Company\Actions\CompanyRevokeUserAction;
use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class UserRevokeController
{
    /**
     * @param Company $company
     * @param User    $user
     *
     * @return JsonResponse
     */
    public function index(Company $company, User $user): JsonResponse
    {
        return UserRevokeConfirmResponse::create($company, $user)
            ->toJson();
    }

    /**
     * @param Company $company
     * @param User    $user
     *
     * @return JsonResponse
     */
    public function action(Company $company, User $user): JsonResponse
    {
        (new CompanyRevokeUserAction($company))($user);

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
            ->toJson();
    }
}
