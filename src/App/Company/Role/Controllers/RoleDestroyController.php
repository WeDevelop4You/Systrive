<?php

namespace App\Company\Role\Controllers;

use App\Company\Role\Responses\RoleDestroyResponse;
use Domain\Company\Models\Company;
use Domain\Role\Mappings\RoleTableMap;
use Domain\Role\Models\Role;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RoleDestroyController
{
    public function index(Company $company, Role $role): JsonResponse
    {
        return RoleDestroyResponse::create($company, $role)->toJson();
    }

    /**
     * @param Company $company
     * @param Role    $role
     *
     * @return JsonResponse
     */
    public function action(Company $company, Role $role): JsonResponse
    {
        if ($role->name !== RoleTableMap::ROLE_MAIN) {
            $role->delete();

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()
                    ->setText(trans('response.success.deleted'))
                )
                ->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.error.delete.admin.role')),
                ResponseCode::HTTP_BAD_REQUEST
            )
            ->toJson();
    }
}
