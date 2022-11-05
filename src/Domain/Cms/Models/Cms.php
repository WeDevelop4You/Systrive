<?php

namespace Domain\Cms\Models;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Company\Models\Company;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Support\Casts\EncryptionCast;
use Support\Helpers\DecryptHelper;
use Support\Services\Cms as CmsService;

/**
 * Domain\Cms\Models\Cms.
 *
 * @property int           $id
 * @property int|null      $company_id
 * @property string        $name
 * @property string        $database
 * @property DecryptHelper $username
 * @property DecryptHelper $password
 * @property Carbon|null   $created_at
 * @property Carbon|null   $updated_at
 * @property Carbon|null   $deleted_at
 * @property-read Company|null $company
 *
 * @method static Builder|Cms                            newModelQuery()
 * @method static Builder|Cms                            newQuery()
 * @method static \Illuminate\Database\Query\Builder|Cms onlyTrashed()
 * @method static Builder|Cms                            query()
 * @method static Builder|Cms                            whereCompanyId($value)
 * @method static Builder|Cms                            whereCreatedAt($value)
 * @method static Builder|Cms                            whereDatabase($value)
 * @method static Builder|Cms                            whereDeletedAt($value)
 * @method static Builder|Cms                            whereId($value)
 * @method static Builder|Cms                            whereName($value)
 * @method static Builder|Cms                            wherePassword($value)
 * @method static Builder|Cms                            whereUpdatedAt($value)
 * @method static Builder|Cms                            whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|Cms withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Cms withoutTrashed()
 *
 * @mixin Eloquent
 */
class Cms extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'cms';

    protected $fillable = [
        CmsTableMap::COMPANY_ID,
        CmsTableMap::NAME,
        CmsTableMap::DATABASE,
        CmsTableMap::USERNAME,
        CmsTableMap::PASSWORD,
    ];

    protected $hidden = [
        CmsTableMap::USERNAME,
        CmsTableMap::PASSWORD,
    ];

    protected $casts = [
        CmsTableMap::USERNAME => EncryptionCast::class,
        CmsTableMap::PASSWORD => EncryptionCast::class,
    ];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return CmsTable[]|Collection
     */
    public function tables(): array|Collection
    {
        CmsService::createConnection($this);

        return CmsTable::all();
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param string      $childType
     * @param mixed       $value
     * @param string|null $field
     *
     * @return Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field): ?Model
    {
        if (\in_array($childType, ['table'])) {
            CmsService::createConnection($this);

            return match ($childType) {
                'table' => CmsTable::where($field ?? CmsTable::getModel()->getKeyName(), $value)->firstOrFail(),
            };
        }

        return parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
