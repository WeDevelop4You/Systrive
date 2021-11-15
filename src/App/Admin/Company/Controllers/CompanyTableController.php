<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Resources\CompanyDataResource;
    use Domain\Company\Models\Company;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Facades\DB;
    use Support\Helpers\Data\Build\Column;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyTableController
    {
        /**
         * @return AnonymousResourceCollection
         */
        public function index(): AnonymousResourceCollection
        {
            return DataTable::create(Company::query())
                ->setColumns($this->createColumns())
                ->get(CompanyDataResource::class);
        }

        /**
         * @return array
         */
        private function createColumns(): array
        {
            return [
                Column::create('id')->sortable()->searchable(),
                Column::create('name')->sortable()->searchable(),
                Column::create('email')->sortable()->searchable(),
                Column::create('owner.full_name')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                        ->whereColumn('companies.owner_id', 'user_profiles.user_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('ownerProfile', function (Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('domain')->sortable()->searchable(),
                Column::create('created_at')->sortable()->searchable(),
            ];
        }
    }
