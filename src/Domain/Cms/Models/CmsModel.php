<?php

namespace Domain\Cms\Models;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Illuminate\Database\Eloquent\Model;
use Support\Services\Cms;

/**
 * CmsColumnTableMap
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsModel whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CmsModel extends Model
{
    protected $connection = 'cms';

    /**
     * CmsModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $table = Cms::getTable();

        $this->setTable($table->name);
        $this->fillable(
            $table->columns->pluck(CmsColumnTableMap::KEY)->toArray()
        );

        parent::__construct($attributes);
    }
}
