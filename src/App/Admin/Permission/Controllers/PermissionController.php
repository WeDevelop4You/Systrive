<?php

    namespace App\Admin\Permission\Controllers;

    use App\Admin\Permission\Resources\PermissionGroupResource;
    use Domain\Permission\DataTransferObjects\PermissionGroupData;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Collection;
    use Spatie\Permission\Models\Permission;
    use Support\Helpers\Response\Response;

    class PermissionController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $data = Permission::all()->groupBy(function (Permission $permission) {
                [$group] = explode('.', $permission->name, 2);

                return $group;
            })->map(function (Collection $permissions, string $group) {
                return new PermissionGroupData($group, $permissions);
            });

            $response = new Response();
            $response->addData(PermissionGroupResource::collection($data));

            return $response->toJson();
        }
    }
