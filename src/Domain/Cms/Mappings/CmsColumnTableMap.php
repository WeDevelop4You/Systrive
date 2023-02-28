<?php

namespace Domain\Cms\Mappings;

class CmsColumnTableMap
{
    public const TABLE = 'cms_columns';
    public const COL_ORIGINAL_KEY = 'original_key';
    public const COL_SELECTABLE_ALL = 'selectable.*';
    public const COL_CREATABLE_ALL = 'creatable.*';
    public const COL_UPDATABLE_ALL = 'updatable.*';
    public const COL_ID = 'id';
    public const COL_TABLE_ID = 'table_id';
    public const COL_LABEL = 'label';
    public const COL_KEY = 'key';
    public const COL_TYPE = 'type';
    public const COL_AFTER = 'after';
    public const COL_HIDDEN = 'hidden';
    public const COL_EDITABLE = 'editable';
    public const COL_DELETABLE = 'deletable';
    public const COL_SELECTABLE = 'selectable';
    public const COL_CREATABLE = 'creatable';
    public const COL_UPDATABLE = 'updatable';
    public const COL_PROPERTIES = 'properties';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const REQUIRED_COLUMNS = ['id', 'created_at', 'updated_at'];
    public const RESERVE_COLUMNS = ['_and', '_or'];
    public const TABLE_ID = 'cms_columns.id';
    public const TABLE_TABLE_ID = 'cms_columns.table_id';
    public const TABLE_LABEL = 'cms_columns.label';
    public const TABLE_KEY = 'cms_columns.key';
    public const TABLE_TYPE = 'cms_columns.type';
    public const TABLE_AFTER = 'cms_columns.after';
    public const TABLE_HIDDEN = 'cms_columns.hidden';
    public const TABLE_EDITABLE = 'cms_columns.editable';
    public const TABLE_DELETABLE = 'cms_columns.deletable';
    public const TABLE_SELECTABLE = 'cms_columns.selectable';
    public const TABLE_CREATABLE = 'cms_columns.creatable';
    public const TABLE_UPDATABLE = 'cms_columns.updatable';
    public const TABLE_PROPERTIES = 'cms_columns.properties';
    public const TABLE_CREATED_AT = 'cms_columns.created_at';
    public const TABLE_UPDATED_AT = 'cms_columns.updated_at';
    public const RELATION_TABLE = 'table';
}
