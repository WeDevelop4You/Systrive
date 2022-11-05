<?php

namespace Domain\Company\Casts;

use Domain\Company\Enums\CompanyModuleTypes;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class CompanyModulesCast implements CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        $value = Collection::json($value ?? '');

        return Collection::make(CompanyModuleTypes::cases())
            ->mapWithKeys(function (CompanyModuleTypes $type) use ($value) {
                $module = $type->value;

                return [$module => $value->get($module, false)];
            });
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        if (is_array($value)) {
            $value = Collection::make($value);
        }

        return Collection::make(CompanyModuleTypes::cases())
            ->mapWithKeys(function (CompanyModuleTypes $type) use ($value) {
                $module = $type->value;

                return [$module => $value->get($module, false)];
            })->toJson();
    }
}
