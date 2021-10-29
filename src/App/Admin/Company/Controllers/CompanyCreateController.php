<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCreateRequests;
    use App\Controller;
    use Domain\Companies\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyCreateController extends Controller
    {
        /**
         * @param CompanyCreateRequests $requests
         *
         * @return JsonResponse
         */
        public function action(CompanyCreateRequests $requests): JsonResponse
        {
            $validated = (object)$requests->validated();

            $company = new Company();
            $company->name = $validated->name;
            $company->email = $validated->email;
            $company->domain = $validated->domain;
            $company->owner_id = $validated->owner;
            $company->save();

            $company->users()->attach($validated->owner);

            $response = new Response(ResponseCode::HTTP_CREATED);
            $response->addPopup(trans('response.success.create.company'));

            return $response->toJson();
        }
    }
