<?php

    namespace Domain\Permission\DataTransferObjects;

    use Illuminate\Support\Collection;
    use Illuminate\Support\Str;
    use Spatie\Permission\Models\Permission;

    final class PermissionGroupData
    {
        /**
         * @var int|null
         */
        public ?int $id = null;

        /**
         * PermissionGroupData constructor.
         *
         * @param string     $group
         * @param Collection $permissions
         */
        public function __construct(
            public string $group,
            public Collection $permissions,
        ) {
            $viewPermission = $this->permissions->filter(function (Permission $permission) {
                return Str::endsWith($permission->name, '.view');
            })->first();

            $this->id = $viewPermission?->id;
        }
    }
