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
    use Support\Helpers\Table\Build\Column;
    use Support\Helpers\Table\Build\DataTable;

    class UserTableController extends Controller
    {
        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            $columns = [
                Column::create('id')->sortable()->searchable(),
                Column::create('profile.full_name')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                        ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('profile', function (Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('email')->sortable()->searchable(),
                Column::create('email_verified_at')->sortable()->searchable(),
                Column::create('created_at')->sortable()->searchable(),
                Column::create('deleted_at')->sortable()->searchable(),
            ];

            return DataTable::create(User::withTrashed())->setColumns($columns)->get(UserDataResource::class);
        }

        /**
         * @param User $user
         * @return JsonResponse
         */
        public function destroy(User $user): JsonResponse
        {
            $user->delete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.account'));

            return $response->toJson();
        }

        /**
         * @param User $user
         * @return JsonResponse
         */
        public function forceDestroy(User $user): JsonResponse
        {
            $user->forceDelete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.force.account'));

            return $response->toJson();
        }
    }
