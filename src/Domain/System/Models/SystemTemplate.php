<?php

    namespace Domain\System\Models;

    use Domain\System\Mappings\SystemTemplateTableMap;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use Support\Enums\System\SystemTemplateTypes;

    /**
     * Domain\System\Models\SystemTemplate.
     *
     * @property int                 $id
     * @property string              $value
     * @property string|null         $name
     * @property SystemTemplateTypes $type
     * @property int                 $is_public
     * @property Carbon|null         $created_at
     * @property Carbon|null         $updated_at
     *
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
            SystemTemplateTableMap::VALUE,
            SystemTemplateTableMap::NAME,
            SystemTemplateTableMap::TYPE,
        ];

        protected $casts = [
            SystemTemplateTableMap::TYPE => SystemTemplateTypes::class,
        ];
    }