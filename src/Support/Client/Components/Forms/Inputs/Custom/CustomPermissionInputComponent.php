<?php

namespace Support\Client\Components\Forms\Inputs\Custom;

use Domain\Permission\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Types\CustomInputComponent;
use Support\Enums\Component\Inputs\CustomInputType;
use Support\Enums\Component\Inputs\CustomPermissionInputType;
use Support\Exceptions\Custom\InvalidInputTypeException;

class CustomPermissionInputComponent extends AbstractInputComponent implements CustomInputComponent
{
    /**
     * Keys always are 'roles' and 'permissions'.
     *
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'CustomInputComponent';
    }

    /**
     * @param CustomInputType|null $inputType
     *
     * @return $this
     *
     * @throws InvalidInputTypeException
     */
    public function setType(CustomInputType|null $inputType = null): static
    {
        if ($inputType instanceof CustomPermissionInputType) {
            return $this->setData('type', $inputType->value);
        }

        throw new InvalidInputTypeException();
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setRoles(array $items): static
    {
        return $this->setData('roles', $items);
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $this->setData('groups', $this->createGroupPermissions());

        return parent::export();
    }

    /**
     * @return array
     */
    private function createGroupPermissions(): array
    {
        return Permission::all()->groupBy(function (Permission $permission) {
            [$group] = explode('.', $permission->name, 2);

            return $group;
        })->map(function (Collection $permissions, string $group) {
            $id = null;

            $items = $permissions->map(function (Permission $permission) use (&$id) {
                $name = $permission->name;
                $split = explode('.', $name, 3);

                if (Str::endsWith($name, '.view')) {
                    $id = $permission->id;

                    return $this->createPermission($permission, 'view');
                }

                if (\count($split) === 2) {
                    return $this->createPermission($permission, 'default');
                }

                return $this->createPermission($permission, $split[1]);
            })->groupBy('subGroup')->toArray();

            return [
                'id' => $id,
                'type' => $group,
                'permissions' => $items,
                'name' => trans("word.{$group}.{$group}"),
            ];
        })->toArray();
    }

    /**
     * @param Permission $permission
     * @param string     $subGroup
     *
     * @return array
     */
    private function createPermission(Permission $permission, string $subGroup): array
    {
        return [
            'id' => $permission->id,
            'subGroup' => $subGroup,
            'name' => trans($permission->name),
        ];
    }
}
