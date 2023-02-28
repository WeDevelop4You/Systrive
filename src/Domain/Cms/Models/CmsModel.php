<?php

namespace Domain\Cms\Models;

use Domain\Cms\Collections\CmsFileCollection;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Support\Services\Cms;

/**
 * CmsColumnTableMap.
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read CmsFileCollection|\Domain\Cms\Models\CmsFile[] $files
 *
 * @method static Builder|CmsModel newModelQuery()
 * @method static Builder|CmsModel newQuery()
 * @method static Builder|CmsModel whereCreatedAt($value)
 * @method static Builder|CmsModel whereId($value)
 * @method static Builder|CmsModel whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CmsModel extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cms';

    /**
     * @var string[]
     */
    protected $with = [
        'files',
    ];

    /**
     * @var string
     */
    protected readonly string $identifier;

    /**
     * CmsModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $table = Cms::getTable();

        if ($table instanceof CmsTable) {
            $this->setTable($table->name);
            $this->fillable(
                $table->fillableColumns()->pluck(CmsColumnTableMap::COL_KEY)->toArray()
            );

            $this->identifier = $table->identifier();
        }

        parent::__construct($attributes);
    }

    public function getMorphClass(): string
    {
        return $this->identifier;
    }

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(CmsFile::class, 'table');
    }
}
