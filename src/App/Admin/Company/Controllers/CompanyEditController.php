<?php

namespace App\Admin\Company\Controllers;

use App\Admin\Company\Requests\CompanyUpdateRequest;
use App\Admin\Company\Responses\CompanyEditResponse;
use Domain\Company\Actions\CompanyUpdateAction;
use Domain\Company\DataTransferObjects\CompanyUpdateData;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class CompanyEditController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return CompanyEditResponse::create($company)->toJson();
    }

    public function action(CompanyUpdateRequest $request, Company $company): JsonResponse
    {
        $data = new CompanyUpdateData(...$request->only(
            'name',
            'email',
            'domain',
            'modules',
            'owner'
        ));
        $removeOwner = $request->get('remove_owner', false);

        (new CompanyUpdateAction($company, $removeOwner))($data);

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
            ->toJson();
    }
}
