<?php

namespace App\Admin\Cms\Requests;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Rules\ArrayMustContainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Support\Abstracts\AbstractRequest;

/**
 * @property CmsTable $table
 */
class CmsTableRequest extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    protected function defaultRules(): array
    {
        $minimal = count(CmsTableTableMap::REQUIRED_COLUMNS) + 1;

        return [
            CmsTableTableMap::NAME => [
                'required', 'string', 'alpha_dash',
                Rule::notIn(CmsTableTableMap::USED_NAMES)
            ],
            CmsTableTableMap::LABEL => ['required', 'string'],
            CmsTableTableMap::EDITABLE => ['required', 'boolean'],
            'columns' => [
                'required', 'array', "min:{$minimal}",
                new ArrayMustContainRule(CmsTableTableMap::REQUIRED_COLUMNS, CmsColumnTableMap::KEY)
            ],
            'columns.*.original_key' => ['required', 'string'],
            'columns.*.key' => ['required', 'string', 'alpha_dash', 'max:64', 'distinct:ignore_case'],
            'columns.*.type' => ['required', new Enum(CmsColumnType::class)],
            'columns.*.label' => ['required', 'string'],
            'columns.*.after' => ['required', 'integer'],
            'columns.*.editable' => ['required', 'boolean'],
            'columns.*.properties' => ['present', 'array'],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function storeRules(): array
    {
        return [
            CmsTableTableMap::NAME => [Rule::unique(CmsTable::class)]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function updateRules(): array
    {
        return [
            CmsTableTableMap::NAME => [Rule::unique(CmsTable::class)->ignore($this->table->id)]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            CmsTableTableMap::NAME => strtolower($this->name ?? ''),
            CmsTableTableMap::EDITABLE => $this->editable ?? false,
        ]);
    }
}
