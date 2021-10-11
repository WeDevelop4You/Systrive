<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserDataResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Facades\DB;
    use Support\Helpers\Table\Build\DataTable;
    use Support\Helpers\Table\Build\Column;

    class UserTableController extends Controller
    {
        /**
         * @return AnonymousResourceCollection
         * @throws BindingResolutionException
         */
        public function index(): AnonymousResourceCollection
        {
            $columns = [
                Column::create('id')->sortable()->searchable(),
                Column::create('profile.full_name')->sortable()->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('profile', function (Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('email')->sortable()->searchable(),
                Column::create('email_verified_at')->sortable()->searchable(),
                Column::create('created_at')->sortable()->searchable(),
            ];

            return DataTable::create(User::query())->setColumns($columns)->get(UserDataResource::class);
        }
    }

