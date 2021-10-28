<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserDataResource;
    use App\Admin\User\Resources\UserListResource;
    use App\Controller;
    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Facades\DB;
    use Support\Helpers\Data\Build\Column;
    use Support\Helpers\Data\Build\DataList;
    use Support\Helpers\Data\Build\DataTable;

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
