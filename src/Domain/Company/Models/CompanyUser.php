<?php

    namespace Domain\Company\Models;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\User\Models\User;
    use Eloquent;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\Pivot;

    /**
     * Domain\Company\Models\CompanyUser.
     *
     * @property int                         $id
     * @property int                         $user_id
     * @property int                         $company_id
     * @property int                         $is_owner
     * @property CompanyUserStatusTypes|null $status
     * @property-read User $user
     *
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser query()
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereCompanyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereIsOwner($value)
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|CompanyUser whereUserId($value)
     * @mixin Eloquent
     */
    class CompanyUser extends Pivot
    {
        protected $table = 'company_user';

        protected $fillable = [
            CompanyUserTableMap::USER_ID,
            CompanyUserTableMap::COMPANY_ID,
            CompanyUserTableMap::IS_OWNER,
            CompanyUserTableMap::STATUS,
        ];

        protected $casts = [
            CompanyUserTableMap::STATUS => CompanyUserStatusTypes::class,
        ];

        /**
         * @return BelongsTo
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
    }
