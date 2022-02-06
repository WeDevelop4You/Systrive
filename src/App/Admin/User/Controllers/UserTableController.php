<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\DataTable\UserTable;
    use App\Admin\User\Resources\UserDataResource;

    use Domain\User\Models\User;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Helpers\Data\Build\DataTable;

    class UserTableController
    {
        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            return DataTable::create(User::withTrashed())
                ->setColumns(UserTable::create())
                ->getData(UserDataResource::class);
        }
    }
