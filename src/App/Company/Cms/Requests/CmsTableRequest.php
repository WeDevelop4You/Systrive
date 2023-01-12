<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Enums\CmsColumnType;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Rules\ArrayMustContainRule;
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
        $minimal = \count(CmsTableTableMap::REQUIRED_COLUMNS) + 1;

        return [
            CmsTableTableMap::COL_NAME => [
                'required', 'string', 'alpha_dash',
                Rule::notIn(CmsTableTableMap::USED_NAMES),
            ],
            CmsTableTableMap::COL_LABEL => ['required', 'string'],
            CmsTableTableMap::COL_EDITABLE => ['required', 'boolean'],
            'columns' => [
                'required', 'array', "min:{$minimal}",
                new ArrayMustContainRule(CmsTableTableMap::REQUIRED_COLUMNS, CmsColumnTableMap::COL_KEY),
            ],
            'columns.*.original_key' => ['required', 'string'],
            'columns.*.key' => ['required', 'string', 'alpha_dash', 'max:64', 'distinct:ignore_case'],
            'columns.*.type' => ['required', new Enum(CmsColumnType::class)],
            'columns.*.label' => ['required', 'string'],
            'columns.*.after' => ['required', 'integer'],
            'columns.*.hidden' => ['required', 'boolean'],
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
            CmsTableTableMap::COL_IS_TABLE => ['required', 'boolean'],
            CmsTableTableMap::COL_NAME => [Rule::unique(CmsTable::class)],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function updateRules(): array
    {
        return [
            CmsTableTableMap::COL_NAME => [Rule::unique(CmsTable::class)->ignore($this->table->id)],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            CmsTableTableMap::COL_NAME => strtolower($this->name ?? ''),
            CmsTableTableMap::COL_EDITABLE => $this->editable ?? false,
            CmsTableTableMap::COL_IS_TABLE => $this->is_table ?? false,
        ]);
    }
}
