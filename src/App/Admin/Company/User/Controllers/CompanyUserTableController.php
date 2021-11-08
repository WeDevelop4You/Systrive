<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Resources\CompanyUserDataResource;
    use App\Controller;
    use Domain\Companies\Models\Company;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Facades\DB;
    use Support\Helpers\Data\Build\Column;
    use Support\Helpers\Data\Build\DataTable;

    class CompanyUserTableController extends Controller
    {
        /**
         * @param Company $company
         *
         * @return AnonymousResourceCollection
         */
        public function index(Company $company): AnonymousResourceCollection
        {
            return DataTable::create($company->users())
                ->setColumns($this->createColumns())
                ->get(CompanyUserDataResource::class);
        }

        /**
         * @return array
         */
        private function createColumns(): array
        {
            return [
                Column::create('profile.full_name')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                        ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('profile', function (Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('email')->sortable()->searchable(),
            ];
        }
    }
