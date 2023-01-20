<?php

namespace Domain\Role\Seeders;

use Domain\Permission\Models\Permission;
use Domain\Role\DataTransferObjects\RoleData;
use Domain\Role\Mappings\RoleTableMap;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractSeeder;

class RoleSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    protected function handler(): Collection
    {
        $permissions = Permission::all();

        return $permissions->mapToGroups(function (Permission $permission) {
            $key = Str::beforeLast($permission->name, '.');

            return [$key => $permission->id];
        })->map(function (Collection $ids, string $key) use ($permissions) {
            if (Str::contains($key, '.')) {
                $group = Str::before($key, '.');
                $view = $permissions->firstWhere('name', "{$group}.view");

                if ($view instanceof Permission) {
                    $ids->prepend($view->id);
                }
            }

            return new RoleData(
                $this->getName($key),
                $ids->toArray()
            );
        })->prepend(
            new RoleData(
                RoleTableMap::ROLE_MAIN,
                $permissions->pluck('id')->toArray()
            ),
            'admin'
        );
    }

    private function getName(string $key): string
    {
        return match ($key) {
            'cms' => Str::upper($key),
            'cms.table' => 'CMS Table',
            default => Str::ucfirst($key),
        };
    }
}
