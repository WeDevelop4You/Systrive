<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\DataTables\UserTable;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Abstracts\Controllers\AbstractTableController;
    use Support\Helpers\DataTable\Build\DataTable;

    class UserTableController extends AbstractTableController
    {
        protected string $dataTable = UserTable::class;

        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return $this->headers();
        }

        /**
         * @return JsonResponse
         */
        public function action(): JsonResponse
        {
            return DataTable::create($this->getDataTable())
                ->query(User::withTrashed())
                ->export();
        }
    }
