<?php

    namespace Support\Helpers\Table;

    use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Str;

    class ColumnHelper
    {
        /**
         * @param $column
         * @return bool
         */
        public static function hasRelation($column): bool
        {
            return Str::contains($column, '.');
        }

        /**
         * @param $column
         * @return string
         */
        public static function parseRelation($column): string
        {
            return Str::beforeLast($column, '.');
        }

        /**
         * @param $column
         * @return string
         */
        public static function parseField($column): string
        {
            return Str::afterLast($column, '.');
        }

        /**
         * @param $column
         * @param $searchColumns
         * @return bool
         */
        public static function hasMatch($column, $searchColumns): bool
        {
            return in_array($column, $searchColumns ?? [], true);
        }

        /**
         * @param $column
         * @param $searchColumns
         * @return bool
         */
        public static function hasWildcardMatch($column, $searchColumns): bool
        {
            return count(array_filter($searchColumns ?? [], function ($searchColumn) use ($column) {
                $hasWildcard = Str::endsWith($searchColumn, '*');

                if (!$hasWildcard) {
                    return false;
                }

                if (!self::hasRelation($column)) {
                    return true;
                }

                $selectColumnPrefix = self::parseRelation($searchColumn);
                $columnPrefix = self::parseRelation($column);

                return $selectColumnPrefix === $columnPrefix;
            })) > 0;
        }

        /**
         * @param  null  $queryBuilder
         *
         * @return array|null
         */
        public static function columnsFromBuilder($queryBuilder = null): ?array
        {
            if ($queryBuilder instanceof EloquentBuilder) {
                return $queryBuilder->getQuery()->columns;
            }

            if ($queryBuilder instanceof Builder) {
                return $queryBuilder->columns;
            }

            return null;
        }

        /**
         * @param $column
         * @param $queryBuilder
         * @return string
         */
        public static function mapToSelected($column, $queryBuilder): ?string
        {
            $select = self::columnsFromBuilder($queryBuilder);

            if (is_null($select)) {
                return null;
            }

            $hasMatch = self::hasMatch($column, $select);

            if ($hasMatch) {
                return $column;
            }

            $hasWildcardMatch = self::hasWildcardMatch($column, $select);

            if ($hasWildcardMatch) {
                return $column;
            }

            $hasRelation = self::hasRelation($column);
            $relationName = self::parseRelation($column);
            $fieldName = self::parseField($column);

            if (!$hasRelation) {
                return null;
            }

            if ($queryBuilder instanceof EloquentBuilder) {
                $relation = $queryBuilder->getRelation($relationName);
                $possibleTable = $relation->getModel()->getTable();
            } elseif ($queryBuilder instanceof Builder) {
                // TODO: Possible ways to do this?
                $possibleTable = null;
            } else {
                $possibleTable = null;
            }

            if (!is_null($possibleTable)) {
                $possibleSelectColumn = $possibleTable . '.' . $fieldName;

                $possibleMatch = self::hasMatch($possibleSelectColumn, $select);

                if ($possibleMatch) {
                    return $possibleSelectColumn;
                }

                $possibleWildcardMatch = self::hasWildcardMatch($possibleSelectColumn, $select);

                if ($possibleWildcardMatch) {
                    return $possibleSelectColumn;
                }
            }

            return null;
        }
    }
