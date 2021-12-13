<?php

    namespace App\Admin\Company\Role\Controllers;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Spatie\Permission\Models\Role;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

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
            $role->delete();

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.delete.company.role')))
                ->toJson();
        }
    }
