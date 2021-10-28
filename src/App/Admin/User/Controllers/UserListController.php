<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserListResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataList;

    class UserListController extends Controller
    {
        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            return DataList::create(User::query(), 'email')->get(UserListResource::class);
        }
    }
