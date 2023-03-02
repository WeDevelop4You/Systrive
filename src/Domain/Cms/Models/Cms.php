<?php

namespace Domain\Cms\Models;

use Domain\Cms\Mappings\CmsTableMap;
use Domain\Company\Models\Company;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Stringable;
use Laravel\Sanctum\HasApiTokens;
use Support\Casts\EncryptionCast;
use Support\Services\Cms as CmsService;
use Support\Utils\Decrypt;

/**
 * Domain\Cms\Models\Cms
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string $database
 * @property Decrypt $username
 * @property Decrypt $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Company|null $company
 * @property-read Collection<int, \Domain\Api\Models\ApiAccessToken> $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|Cms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cms onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cms query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cms withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Cms withoutTrashed()
 * @mixin Eloquent
 */
class Cms extends Model
{
    use SoftDeletes;
    use Prunable;
    use HasApiTokens;

    /**
     * @var string
     */
    protected $table = 'cms';

    protected $fillable = [
        CmsTableMap::COL_COMPANY_ID,
        CmsTableMap::COL_NAME,
        CmsTableMap::COL_DATABASE,
        CmsTableMap::COL_USERNAME,
        CmsTableMap::COL_PASSWORD,
    ];

    protected $hidden = [
        CmsTableMap::COL_USERNAME,
        CmsTableMap::COL_PASSWORD,
    ];

    protected $casts = [
        CmsTableMap::COL_USERNAME => EncryptionCast::class,
        CmsTableMap::COL_PASSWORD => EncryptionCast::class,
    ];

    /**
     * @return Builder
     */
    public function prunable(): Builder
    {
        return static::whereDate(CmsTableMap::COL_DELETED_AT, '<', Carbon::now()->subDays(31));
    }

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
     * @return Stringable
     */
    public function storagePath(): Stringable
    {
        return $this->company->storagePath()
            ->append('/cms/', md5($this->id));
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
