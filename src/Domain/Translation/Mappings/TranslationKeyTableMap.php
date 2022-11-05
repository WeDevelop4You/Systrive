<?php

namespace Domain\Translation\Mappings;

class TranslationKeyTableMap
{
    public const TABLE = 'translation_keys';

    public const ID = 'id';
    public const ENVIRONMENT = 'environment';
    public const GROUP = 'group';
    public const KEY = 'key';
    public const TAGS = 'tags';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'translation_keys.id';
    public const TABLE_ENVIRONMENT = 'translation_keys.environment';
    public const TABLE_GROUP = 'translation_keys.group';
    public const TABLE_KEY = 'translation_keys.key';
    public const TABLE_TAGS = 'translation_keys.tags';
    public const TABLE_CREATED_AT = 'translation_keys.created_at';
    public const TABLE_UPDATED_AT = 'translation_keys.updated_at';

    public const RELATIONSHIP_TRANSLATIONS = 'translations';
    public const RELATIONSHIP_SOURCES = 'sources';
}
