<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Columns\Options\AbstractColumnOption;
use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Support\Abstracts\AbstractRequest;

/**
 * @property array  $keys
 * @property string $key
 * @property string $hidden
 * @property string $editable
 * @property int    $type
 */
class CmsTableColumnRequest extends AbstractRequest
{
    /**
     * @var string|null
     */
    private string|null $prefix = null;

    /**
     * @param string|null $prefix
     */
    public function setPrefix(string|null $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * Required/default columns doesn't have properties.
     *
     * @return bool
     */
    protected function isUpdating(): bool
    {
        return \in_array($this->key, CmsTableTableMap::REQUIRED_COLUMNS);
    }

    protected function defaultRules(): array
    {
        $keys = array_map('strtolower', $this->keys ?? []);

        return [
            CmsColumnTableMap::COL_KEY => ['required', 'string', 'alpha_dash', 'max:64', Rule::notIn($keys)],
            CmsColumnTableMap::COL_TYPE => ['required', new Enum(CmsColumnType::class)],
            CmsColumnTableMap::COL_LABEL => ['required', 'string'],
            CmsColumnTableMap::COL_HIDDEN => ['required', 'boolean'],
            CmsColumnTableMap::COL_EDITABLE => ['required', 'boolean'],
        ];
    }

    protected function storeRules(): array
    {
        $optionRules = CmsColumnType::from($this->type)
            ->options($this->prefix)
            ->mapWithKeys(
                fn (AbstractColumnOption $option) => $option->getRequirements($this)
            )->toArray();

        return [
            CmsColumnTableMap::COL_PROPERTIES => ['required', 'array'],
            ...$optionRules,
        ];
    }

    protected function updateRules(): array
    {
        return [];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            CmsColumnTableMap::COL_KEY => strtolower($this->key),
            CmsColumnTableMap::COL_HIDDEN => $this->hidden ?? false,
            CmsColumnTableMap::COL_EDITABLE => $this->editable ?? false,
        ]);
    }
}
