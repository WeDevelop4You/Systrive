<?php

namespace Domain\Cms\Casts;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\CmsColumn;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CmsColumnPropertiesCast implements CastsAttributes
{
    /**
     * @param CmsColumn $model
     * @param string    $key
     * @param           $value
     * @param array     $attributes
     *
     * @return Collection
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        $type = Arr::get($attributes, CmsColumnTableMap::COL_TYPE);

        if (!is_null($type)) {
            return CmsColumnType::from($type)->options()
                ->map(function (AbstractColumnOption $option) use ($value) {
                    return $option->setProperties(Collection::json($value ?? ''));
                });
        }

        return Collection::make();
    }

    /**
     * @param CmsColumn $model
     * @param string    $key
     * @param           $value
     * @param array     $attributes
     *
     * @return string
     */
    public function set($model, string $key, $value, array $attributes): string
    {
        $key = Arr::get($attributes, CmsColumnTableMap::COL_KEY);

        if (CmsColumn::isRequired($key)) {
            return json_encode([]);
        }

        $value = $this->getValue($value);

        if (is_string($value)) {
            return $value;
        }

        $type = Arr::get($attributes, CmsColumnTableMap::COL_TYPE);

        return CmsColumnType::from($type)->options()
            ->mapWithKeys(function (AbstractColumnOption $option) use ($value) {
                $key = $option->getKey();

                return [$key => $value->get($key, $option->getDefault())];
            })->toJson();
    }

    /**
     * @param $value
     *
     * @return Collection|string
     */
    private function getValue($value): Collection|string
    {
        if ($value instanceof Collection) {
            $options = $value->filter(fn ($option) => $option instanceof AbstractColumnOption);

            if ($options->isNotEmpty()) {
                return $options->mapWithKeys(function (AbstractColumnOption $option) {
                    return [$option->getKey() => $option->getValue()];
                })->toJson();
            }

            return $value;
        }

        return Collection::make($value);
    }
}
