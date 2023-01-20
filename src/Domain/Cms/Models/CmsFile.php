<?php

namespace Domain\Cms\Models;

use Domain\Cms\Collections\CmsFileCollection;
use Domain\Cms\Mappings\CmsFileTableMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 *
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereName($value)
 *
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Query\Builder|CmsFile    onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsFile whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CmsFile    withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CmsFile    withoutTrashed()
 * @method static CmsFileCollection|static[]                    all($columns = ['*'])
 * @method static CmsFileCollection|static[]                    get($columns = ['*'])
 */
class CmsFile extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $connection = 'cms';

    protected $fillable = [
        CmsFileTableMap::COL_TABLE_TYPE,
        CmsFileTableMap::COL_TABLE_ID,
        CmsFileTableMap::COL_TABLE_KEY,
        CmsFileTableMap::COL_PATH,
        CmsFileTableMap::COL_NAME,
        CmsFileTableMap::COL_SIZE,
        CmsFileTableMap::COL_TYPE,
    ];

    protected $table = 'cms_files';

    public function forceDeleteQuietly()
    {
        return static::withoutEvents(fn () => $this->forceDelete());
    }

    /**
     * @param array $models
     *
     * @return CmsFileCollection
     */
    public function newCollection(array $models = []): CmsFileCollection
    {
        return new CmsFileCollection($models);
    }
}
