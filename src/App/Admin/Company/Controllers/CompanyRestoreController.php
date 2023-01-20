<?php

namespace App\Admin\Company\Controllers;

use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class CompanyRestoreController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function action(Company $company): JsonResponse
    {
        $company->restore();

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.restored')))
            ->toJson();
    }
}
