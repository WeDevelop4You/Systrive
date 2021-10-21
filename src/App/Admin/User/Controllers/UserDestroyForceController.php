<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserDataResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Facades\DB;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Table\Build\DataTable;
    use Support\Helpers\Table\Build\Column;

    class UserDestroyForceController extends Controller
    {
        /**
         * @param User $user
         * @return JsonResponse
         */
        public function action(User $user): JsonResponse
        {
            $user->forceDelete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.force.account'));

            return $response->toJson();
        }
    }

