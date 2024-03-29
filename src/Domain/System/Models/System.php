<?php

namespace Domain\System\Models;

use Domain\Company\Models\Company;
use Domain\System\Mappings\SystemTableMap;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Domain\System\Models\System
 *
 * @property int         $id
 * @property int|null    $company_id
 * @property string      $username
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\System\Models\SystemDatabase> $databases
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\System\Models\SystemDNS> $dns
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\System\Models\SystemDomain> $domains
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\System\Models\SystemMailDomain> $mailDomains
 *
 * @method static Builder|System newModelQuery()
 * @method static Builder|System newQuery()
 * @method static Builder|System query()
 * @method static Builder|System whereCompanyId($value)
 * @method static Builder|System whereCreatedAt($value)
 * @method static Builder|System whereId($value)
 * @method static Builder|System whereUpdatedAt($value)
 * @method static Builder|System whereUsername($value)
 *
 * @mixin Eloquent
 */
class System extends Model
{
    protected $table = 'system';

    protected $fillable = [
        SystemTableMap::COL_COMPANY_ID,
        SystemTableMap::COL_USERNAME,
    ];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return HasMany
     */
    public function domains(): HasMany
    {
        return $this->hasMany(SystemDomain::class);
    }

    /**
     * @return HasMany
     */
    public function dns(): HasMany
    {
        return $this->hasMany(SystemDNS::class);
    }

    /**
     * @return HasMany
     */
    public function databases(): HasMany
    {
        return $this->hasMany(SystemDatabase::class);
    }

    /**
     * @return HasMany
     */
    public function mailDomains(): HasMany
    {
        return $this->hasMany(SystemMailDomain::class);
    }
}
