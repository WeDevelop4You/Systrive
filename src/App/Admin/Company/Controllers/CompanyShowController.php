<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyShowResource;

    use Domain\Company\Models\Company;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Support\Exceptions\Handlers\ModelNotFoundException as ModelNotFoundExceptionHandler;
    use Support\Helpers\Response\Response;

    class CompanyShowController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            $response = new Response();
            $response->addData($company, CompanyShowResource::class);

            return $response->toJson();
        }

        /**
         * @param string $companyName
         *
         * @throws ModelNotFoundExceptionHandler
         *
         * @return JsonResponse
         */
        public function search(string $companyName): JsonResponse
        {
            try {
                $company = Company::whereName($companyName)->firstOrFail();
            } catch (ModelNotFoundException) {
                $throw = new ModelNotFoundExceptionHandler();
                $throw->lastRouteAction = true;

                throw $throw;
            }

            $response = new Response();
            $response->addData($company, CompanyShowResource::class);

            return $response->toJson();
        }
    }
