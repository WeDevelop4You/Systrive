<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyUpdateRequest;
    use App\Admin\Company\Responses\CompanyEditResponse;
    use Domain\Company\Actions\UpdateCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

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
            $data = new CompanyData(...$request->only('name', 'email', 'domain', 'information', 'owner'));
            $removeOwner = $request->get('remove_owner', false);

            (new UpdateCompanyAction($company, $removeOwner))($data);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
