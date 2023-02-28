<?php

namespace App\Company\Cms\Requests;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Rules\ArrayMustContainRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Support\Abstracts\AbstractRequest;

/**
 * @property CmsTable $table
 */
class CmsTableRequest extends AbstractRequest
{
    /**
     * {@inheritDoc}
     */
    protected function defaultRules(): array
    {
        $minimal = count(CmsColumnTableMap::REQUIRED_COLUMNS) + 1;

        return [
            CmsTableTableMap::COL_NAME => [
                'required', 'string', 'alpha_dash',
                Rule::notIn(CmsTableTableMap::USED_NAMES),
            ],
            CmsTableTableMap::COL_LABEL => ['required', 'string'],
            CmsTableTableMap::COL_EDITABLE => ['required', 'boolean'],
            CmsTableTableMap::COL_COLUMNS => [
                'required', 'array', "min:{$minimal}",
                new ArrayMustContainRule(CmsColumnTableMap::REQUIRED_COLUMNS, CmsColumnTableMap::COL_KEY),
            ],
            CmsTableTableMap::COL_COLUMNS_ALL => Rule::forEach(function ($value, $attribute) {
                Arr::set($value, 'key', Str::lower(Arr::get($value, 'key', '')));

                /** @var CmsTableColumnRequest $clone */
                $clone = self::createFrom($this, new CmsTableColumnRequest);
                $clone->setPrefix($attribute);
                $clone->json->replace($value);
                $clone->request->replace($value);
                $clone->content = json_encode($value);

                return [
                    ...$clone->rules(),
                    'key' => ['required', 'string', 'alpha_dash', 'max:64', 'distinct', Rule::notIn(CmsColumnTableMap::RESERVE_COLUMNS)],
                    'after' => ['required', 'integer'],
                    'original_key' => ['required', 'string'],
                ];
            }),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function storeRules(): array
    {
        return [
            CmsTableTableMap::COL_IS_TABLE => ['required', 'boolean'],
            CmsTableTableMap::COL_NAME => [Rule::unique(CmsTable::class)],
        ];
    }

    /**
     * {@inheritDoc}
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
