<?php

    namespace Domain\Company\Models;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Observers\CompanyUserDeletingObserver;
    use Domain\Company\Observers\CompanyUserUpdatedObserver;
    use Domain\Company\QueryBuilders\CompanyUserQueryBuilders;
    use Domain\User\Models\User;
    use Eloquent;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\Pivot;
    use Support\Traits\Observers;

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
     * @method static CompanyUserQueryBuilders|CompanyUser firstWithInvite(\Domain\Invite\Models\Invite $invite)
     * @method static CompanyUserQueryBuilders|CompanyUser newModelQuery()
     * @method static CompanyUserQueryBuilders|CompanyUser newQuery()
     * @method static CompanyUserQueryBuilders|CompanyUser query()
     * @method static CompanyUserQueryBuilders|CompanyUser whereCompanyId($value)
     * @method static CompanyUserQueryBuilders|CompanyUser whereId($value)
     * @method static CompanyUserQueryBuilders|CompanyUser whereIsOwner($value)
     * @method static CompanyUserQueryBuilders|CompanyUser whereStatus($value)
     * @method static CompanyUserQueryBuilders|CompanyUser whereUserId($value)
     * @mixin Eloquent
     */
    class CompanyUser extends Pivot
    {
        use Observers;

        protected $table = 'company_user';

        public $timestamps = false;

        protected $fillable = [
            CompanyUserTableMap::USER_ID,
            CompanyUserTableMap::COMPANY_ID,
            CompanyUserTableMap::IS_OWNER,
            CompanyUserTableMap::STATUS,
        ];

        protected $casts = [
            CompanyUserTableMap::STATUS => CompanyUserStatusTypes::class,
        ];

        protected array $observers = [
            'updated' => CompanyUserUpdatedObserver::class,
            'deleted' => CompanyUserDeletingObserver::class,
        ];

        /**
         * @return BelongsTo
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class)->withTrashed();
        }

        /**
         * @param $query
         *
         * @return CompanyUserQueryBuilders
         */
        public function newEloquentBuilder($query): CompanyUserQueryBuilders
        {
            return new CompanyUserQueryBuilders($query);
        }
    }
