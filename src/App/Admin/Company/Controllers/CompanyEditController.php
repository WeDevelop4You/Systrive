<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyEditRequests;
    use App\Admin\Company\Resources\CompanyResource;
    use App\Controller;
    use Domain\Companies\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyEditController extends Controller
    {
        /**
         * @param Company $company
         * @return JsonResponse
         */
        public function index(Company $company): JsonResponse
        {
            $response = new Response();
            $response->addData($company, CompanyResource::class);

            return $response->toJson();
        }

        public function action(CompanyEditRequests $request, Company $company): JsonResponse
        {
            $validated = (object) $request->validated();

            $company->name = $validated->name;
            $company->email = $validated->email;
            $company->domain = $validated->domain;
            $company->owner_id = $validated->owner;

            if ($company->isDirty('owner_id')) {
                $company->users()->syncWithoutDetaching($validated->owner);

                if ($validated->removeUser) {
                    $company->users()->detach($company->getRawOriginal('owner_id'));
                }
            }

            $company->save();

            $response = new Response();
            $response->addPopup(trans('response.success.update.company'));

            return $response->toJson();
        }
    }
