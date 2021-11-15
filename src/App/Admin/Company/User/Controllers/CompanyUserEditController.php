<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserUpdateRequest;
    use App\Admin\Company\User\Resources\CompanyUserResource;
    use Domain\Company\Actions\UserPermissionsForCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class CompanyUserEditController
    {
        /**
         * @param Company $company
         * @param User    $user
         *
         * @return JsonResponse
         */
        public function index(Company $company, User $user): JsonResponse
        {
            setPermissionsTeamId($company->id);

            $response = new Response();
            $response->addData($user, CompanyUserResource::class);

            return $response->toJson();
        }

        /**
         * @param CompanyUserUpdateRequest $request
         * @param Company                  $company
         * @param User                     $user
         *
         * @return JsonResponse
         */
        public function action(CompanyUserUpdateRequest $request, company $company, User $user): JsonResponse
        {
            $data = new CompanyUserData(...$request->validated());

            (new UserPermissionsForCompanyAction($company, $user))($data);

            $response = new Response();
            $response->addPopup(trans('response.success.update.user.company.access'));

            return $response->toJson();
        }
    }
