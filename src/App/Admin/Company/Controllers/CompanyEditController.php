<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyUpdateRequest;
    use App\Admin\Company\Resources\CompanyResource;
    use Domain\Company\Actions\EditCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyEditController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            $response = new Response();
            $response->addData(CompanyResource::make($company));

            return $response->toJson();
        }

        public function action(CompanyUpdateRequest $request, Company $company): JsonResponse
        {
            $data = new CompanyData(...$request->validated());
            $removeUser = $request->get('removeUser', false);

            (new EditCompanyAction($company, $removeUser))($data);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.update.company')))
                ->toJson();
        }
    }
