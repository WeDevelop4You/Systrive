<?php

namespace Support\Traits;

trait DatabaseEnumSearch
{
    abstract public static function getTranslations();

    public function getTranslation(): string
    {
        return self::getTranslations()[$this->value];
    }

    public static function search(string $value): array
    {
        $value = strtolower(preg_quote($value, '~'));

        return array_keys(preg_grep("~{$value}~", array_map('strtolower', self::getTranslations())));
    }
}
