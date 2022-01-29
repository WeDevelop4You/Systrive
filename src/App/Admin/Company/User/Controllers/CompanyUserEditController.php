<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserUpdateRequest;
    use App\Admin\Company\User\Resources\CompanyUserResource;
    use Domain\Company\Actions\User\UserPermissionsForCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
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
            $response->addData(CompanyUserResource::make($user));

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

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.update.user.company.access')))
                ->toJson();
        }
    }
