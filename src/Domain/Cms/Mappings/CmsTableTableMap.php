<?php

namespace Domain\Cms\Mappings;

class CmsTableTableMap
{
    public const TABLE = 'cms_tables';
    public const COL_COLUMNS = 'columns';
    public const COL_COLUMNS_ALL = 'columns.*';
    public const COL_ID = 'id';
    public const COL_LABEL = 'label';
    public const COL_NAME = 'name';
    public const COL_EDITABLE = 'editable';
    public const COL_IS_TABLE = 'is_table';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';
    public const REQUIRED_COLUMNS = ['id', 'created_at', 'updated_at'];
    public const USED_NAMES = ['cms_tables', 'cms_columns', 'cms_files', 'migrations'];
    public const TABLE_ID = 'cms_tables.id';
    public const TABLE_LABEL = 'cms_tables.label';
    public const TABLE_NAME = 'cms_tables.name';
    public const TABLE_EDITABLE = 'cms_tables.editable';
    public const TABLE_IS_TABLE = 'cms_tables.is_table';
    public const TABLE_CREATED_AT = 'cms_tables.created_at';
    public const TABLE_UPDATED_AT = 'cms_tables.updated_at';
    public const RELATION_COLUMNS = 'columns';
    public const RELATION_FORM_COLUMNS = 'formColumns';
    public const RELATION_TABLE_COLUMNS = 'tableColumns';
    public const RELATION_FILE_COLUMNS = 'fileColumns';
    public const RELATION_FILLABLE_COLUMNS = 'fillableColumns';
    public const RELATION_SELECTABLE_COLUMNS = 'selectableColumns';
}
