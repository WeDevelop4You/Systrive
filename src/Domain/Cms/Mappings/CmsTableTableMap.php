<?php

namespace Domain\Cms\Mappings;

class CmsTableTableMap
{
    public const TABLE = 'cms_tables';

    public const REQUIRED_COLUMNS = ['id', 'created_at', 'updated_at'];

    public const USED_NAMES = ['cms_tables', 'cms_columns', 'cms_files', 'migrations'];

    public const COL_ID = 'id';
    public const COL_LABEL = 'label';
    public const COL_NAME = 'name';
    public const COL_EDITABLE = 'editable';
    public const COL_IS_TABLE = 'is_table';
    public const COL_CREATED_AT = 'created_at';
    public const COL_UPDATED_AT = 'updated_at';

    public const TABLE_ID = 'cms_tables.id';
    public const TABLE_LABEL = 'cms_tables.label';
    public const TABLE_NAME = 'cms_tables.name';
    public const TABLE_EDITABLE = 'cms_tables.editable';
    public const TABLE_IS_TABLE = 'cms_tables.is_table';
    public const TABLE_CREATED_AT = 'cms_tables.created_at';
    public const TABLE_UPDATED_AT = 'cms_tables.updated_at';

    public const RELATION_COLUMNS = 'columns';
}
