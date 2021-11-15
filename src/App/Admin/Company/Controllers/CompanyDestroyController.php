<?php

    namespace App\Admin\Company\Controllers;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyDestroyController
    {
        /**
         * @param Company $company
         *
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
