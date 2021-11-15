<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCreateRequest;

    use Domain\Company\Actions\CreateCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyData;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyCreateController
    {
        /**
         * @param CompanyCreateRequest $requests
         *
         * @return JsonResponse
         */
        public function action(CompanyCreateRequest $requests): JsonResponse
        {
            $data = new CompanyData(...$requests->validated());

            (new CreateCompanyAction())($data);

            $response = new Response(ResponseCode::HTTP_CREATED);
            $response->addPopup(trans('response.success.create.company'));

            return $response->toJson();
        }
    }
