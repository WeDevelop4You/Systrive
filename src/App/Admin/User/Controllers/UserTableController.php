<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\DataTables\UserTable;
    use App\Admin\User\Resources\UserDataResource;

    use Domain\User\Models\User;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class UserTableController extends AbstractTableController
    {
        protected function getTableStructure(): AbstractTable
        {
            return UserTable::create();
        }

        /**
         * @return AnonymousResourceCollection
         */
        public function items(): AnonymousResourceCollection
        {
            return DataTable::query(User::withTrashed())
                ->setColumns($this->getTableStructure())
                ->export(UserDataResource::class);
        }
    }
