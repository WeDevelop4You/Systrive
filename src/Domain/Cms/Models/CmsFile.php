<?php

namespace Domain\Cms\Models;

use Domain\Cms\Mappings\CmsFileTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\Cms\Models\CmsFile.
 *
 * @property int                             $id
 * @property string                          $table_type
 * @property int                             $table_id
 * @property string                          $table_key
 * @property string                          $path
 * @property string                          $type
 * @property int                             $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereTableKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereTableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CmsFile extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cms';

    protected $fillable = [
        CmsFileTableMap::COL_TABLE_TYPE,
        CmsFileTableMap::COL_TABLE_ID,
        CmsFileTableMap::COL_TABLE_KEY,
        CmsFileTableMap::COL_PATH,
        CmsFileTableMap::COL_SIZE,
        CmsFileTableMap::COL_TYPE,
    ];

    protected $table = 'cms_files';
}
