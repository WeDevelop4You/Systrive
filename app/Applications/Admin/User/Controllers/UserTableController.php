<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserDataResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Table\DataTableHelper;

    class UserTableController extends Controller
    {
        /**
         * @return AnonymousResourceCollection
         * @throws BindingResolutionException
         */
        public function index(): AnonymousResourceCollection
        {
            return UserDataResource::collection(DataTableHelper::create(User::query())->get());
        }
    }
