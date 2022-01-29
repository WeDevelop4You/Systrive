<?php

    namespace Domain\System\Models;

    use Domain\Company\Models\Company;
    use Domain\System\Mappings\SystemUserTableMap;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Support\Carbon;

    /**
     * Domain\System\Models\SystemUser.
     *
     * @property int         $id
     * @property int|null    $company_id
     * @property string      $username
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Company|null $company
     * @property-read \Domain\System\Models\SystemUserDatabase[]|\Illuminate\Database\Eloquent\Collection $databases
     * @property-read \Domain\System\Models\SystemUserDNS[]|\Illuminate\Database\Eloquent\Collection $dns
     * @property-read \Domain\System\Models\SystemUserDomain[]|\Illuminate\Database\Eloquent\Collection $domains
     * @property-read \Domain\System\Models\SystemUserMailDomain[]|\Illuminate\Database\Eloquent\Collection $mailDomains
     *
     * @method static Builder|SystemUser newModelQuery()
     * @method static Builder|SystemUser newQuery()
     * @method static Builder|SystemUser query()
     * @method static Builder|SystemUser whereCompanyId($value)
     * @method static Builder|SystemUser whereCreatedAt($value)
     * @method static Builder|SystemUser whereId($value)
     * @method static Builder|SystemUser whereUpdatedAt($value)
     * @method static Builder|SystemUser whereUsername($value)
     * @mixin Eloquent
     */
    class SystemUser extends Model
    {
        protected $table = 'system_users';

        protected $fillable = [
            SystemUserTableMap::COMPANY_ID,
            SystemUserTableMap::USERNAME,
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
            return $this->hasMany(SystemUserDomain::class);
        }

        /**
         * @return HasMany
         */
        public function dns(): HasMany
        {
            return $this->hasMany(SystemUserDNS::class);
        }

        /**
         * @return HasMany
         */
        public function databases(): HasMany
        {
            return $this->hasMany(SystemUserDatabase::class);
        }

        /**
         * @return HasMany
         */
        public function mailDomains(): HasMany
        {
            return $this->hasMany(SystemUserMailDomain::class);
        }
    }
