<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserDataResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Table\DataTableHelper;
    use Support\Helpers\Table\TableColumn;

    class UserTableController extends Controller
    {
        /**
         * @return AnonymousResourceCollection
         * @throws BindingResolutionException
         */
        public function index(): AnonymousResourceCollection
        {
            $columns = [
                TableColumn::create('id'),
                TableColumn::create('email'),
                TableColumn::create('email_verified_at'),
                TableColumn::create('created_at'),
            ];

            return UserDataResource::collection(DataTableHelper::create(User::query())->setColumns($columns)->get());
        }
    }
