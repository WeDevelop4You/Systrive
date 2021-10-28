<?php

    namespace App\Admin\Company\Controllers;

    use App\Controller;
    use Domain\Companies\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDestroyController extends Controller
    {
        /**
         * @param Company $company
         * @return JsonResponse
         */
        public function action(Company $company): JsonResponse
        {
            $company->delete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.company'));

            return $response->toJson();
        }
    }
