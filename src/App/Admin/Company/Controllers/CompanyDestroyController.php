<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Responses\CompanyDestroyResponse;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class CompanyDestroyController
{
    public function index(Company $company): JsonResponse
    {
        return CompanyDestroyResponse::create($company)->toJson();
    }

    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function action(Company $company): JsonResponse
    {
        $company->delete();

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
            ->toJson();
    }
}
