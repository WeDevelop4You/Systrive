<?php

    namespace App\Admin\Permission\Resources;

    use Domain\Permission\DataTransferObjects\PermissionGroupData;
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    use Spatie\Permission\Models\Permission;

    /**
     * @mixin PermissionGroupData
     */
    class PermissionGroupResource extends JsonResource
    {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function toArray($request): array
        {
            $name = "word.{$this->group}.{$this->group}";

            return [
                'id' => $this->id,
                'type' => $this->group,
                'name' => trans($name),
                'permissions' => $this->permissions->map(function (Permission $permission) {
                    $split = explode('.', $permission->name, 3);

                    if ($this->id === $permission->id) {
                        return $this->createPermission($permission, 'view');
                    }

                    if (count($split) === 2) {
                        return $this->createPermission($permission, 'default');
                    }

                    return $this->createPermission($permission, $split[1]);
                })->groupBy('subGroup')->toArray(),
            ];
        }

        private function createPermission(Permission $permission, string $subGroup): array
        {
            return [
                'subGroup' => $subGroup,
                'id' => $permission->id,
                'name' => trans($permission->name),
            ];
        }
    }
