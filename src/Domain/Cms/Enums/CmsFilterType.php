<?php

namespace Domain\Cms\Enums;

use GraphQL\Error\Error;
use Illuminate\Database\Eloquent\Builder;

enum CmsFilterType: string
{
    case EQ = '_eq';
    case NEQ = '_neq';
    case LT = '_lt';
    case LTE = '_lte';
    case GT = '_gt';
    case GTE = '_gte';
    case LIKE = '_like';
    case NLIKE = '_nlike';
    case IS_NULL = '_is_null';
    case IN = '_in';
    case NIN = '_nin';
    case AND = '_and';
    case OR = '_or';

    /**
     * @return array
     */
    public static function booleans(): array
    {
        return [
            self::AND->value,
            self::OR->value,
        ];
    }

    /**
     * @param Builder $query
     * @param string  $column
     * @param mixed   $value
     * @param string  $boolean
     *
     * @return void
     *
     * @throws Error
     */
    public function query(Builder $query, string $column, mixed $value, string $boolean): void
    {
        match ($this) {
            self::EQ => $query->where($column, '=', $value, $boolean),
            self::NEQ => $query->where($column, '!=', $value, $boolean),
            self::LT => $query->where($column, '<', $value, $boolean),
            self::LTE => $query->where($column, '<=', $value, $boolean),
            self::GT => $query->where($column, '>', $value, $boolean),
            self::GTE => $query->where($column, '>=', $value, $boolean),
            self::LIKE => $query->where($column, 'like', $value, $boolean),
            self::NLIKE => $query->where($column, 'not like', $value, $boolean),
            self::IS_NULL => $query->whereNull($column, $boolean, !$value),
            self::IN => $query->whereIn($column, $value, $boolean),
            self::NIN => $query->whereNotIn($column, $value, $boolean),
            default => throw new Error('Filter type not supported')
        };
    }
}
