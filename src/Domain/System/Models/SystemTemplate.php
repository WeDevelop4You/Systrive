<?php

namespace Domain\System\Models;

use Domain\System\Mappings\SystemTemplateTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Support\Enums\System\SystemTemplateType;

/**
 * Domain\System\Models\SystemTemplate
 *
 * @property int $id
 * @property string $value
 * @property string|null $name
 * @property SystemTemplateType $type
 * @property int $is_public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SystemTemplate newModelQuery()
 * @method static Builder|SystemTemplate newQuery()
 * @method static Builder|SystemTemplate query()
 * @method static Builder|SystemTemplate whereCreatedAt($value)
 * @method static Builder|SystemTemplate whereId($value)
 * @method static Builder|SystemTemplate whereIsPublic($value)
 * @method static Builder|SystemTemplate whereName($value)
 * @method static Builder|SystemTemplate whereType($value)
 * @method static Builder|SystemTemplate whereUpdatedAt($value)
 * @method static Builder|SystemTemplate whereValue($value)
 * @mixin Eloquent
 */
class SystemTemplate extends Model
{
    protected $table = 'system_templates';

    protected $fillable = [
        SystemTemplateTableMap::COL_VALUE,
        SystemTemplateTableMap::COL_NAME,
        SystemTemplateTableMap::COL_TYPE,
    ];

    protected $casts = [
        SystemTemplateTableMap::COL_TYPE => SystemTemplateType::class,
    ];
}
