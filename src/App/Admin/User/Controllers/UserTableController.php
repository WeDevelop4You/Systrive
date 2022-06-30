<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\DataTables\UserTable;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\AbstractTable;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\Data\Build\DataTable;

    class UserTableController extends AbstractTableController
    {
        protected function getDataTable(): AbstractTable
        {
            return UserTable::create();
        }

        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query(User::withTrashed())
                ->export();
        }
    }
