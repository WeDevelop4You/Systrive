<?php

namespace Domain\Translation\Mappings;

class TranslationKeyTableMap
{
    public const TABLE = 'translation_keys';
    public const COL_ID = 'id';
    public const COL_ENVIRONMENT = 'environment';
    public const COL_GROUP = 'group';
    public const COL_KEY = 'key';
    public const COL_TAGS = 'tags';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const TABLE_ID = 'translation_keys.id';
    public const TABLE_ENVIRONMENT = 'translation_keys.environment';
    public const TABLE_GROUP = 'translation_keys.group';
    public const TABLE_KEY = 'translation_keys.key';
    public const TABLE_TAGS = 'translation_keys.tags';
    public const TABLE_CREATED_AT = 'translation_keys.created_at';
    public const TABLE_UPDATED_AT = 'translation_keys.updated_at';
    public const RELATION_TRANSLATIONS = 'translations';
    public const RELATION_SOURCES = 'sources';
}
