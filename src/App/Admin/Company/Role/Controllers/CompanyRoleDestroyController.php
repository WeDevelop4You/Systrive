<?php

    namespace App\Admin\Company\Role\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyRoleDestroyController
    {
        /**
         * @param Company $company
         * @param Role    $role
         *
         * @return JsonResponse
         */
        public function action(Company $company, Role $role): JsonResponse
        {
            $response = new Response();

            if ($role->name !== RoleTableMap::MAIN_ROLE) {
                $role->delete();

                return $response->addPopup(new SimpleNotification(trans('response.success.deleted')))
                    ->toJson();
            }

            return $response->addPopup(
                new SimpleNotification(trans('response.error.delete.admin.role')),
                ResponseCodes::HTTP_BAD_REQUEST
            )
                ->toJson();
        }
    }
