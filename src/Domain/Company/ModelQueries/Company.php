<?php

    namespace Domain\Company\ModelQueries;

    use Domain\Company\Models\CompanyUser;
    use Domain\Invite\Models\Invite;
    use Domain\Role\Models\Role;
    use Domain\System\Models\SystemUser;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    /**
     * Domain\Company\ModelQueries\Company.
     *
     * @property int                             $id
     * @property int|null                        $owner_id
     * @property string                          $name
     * @property string|null                     $email
     * @property string|null                     $domain
     * @property string|null                     $information
     * @property string                          $status
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|Invite[] $invites
     * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
     * @property-read SystemUser|null $systemUser
     * @property-read \Domain\User\Collections\UserCollections|User[] $users
     * @property-read \Domain\User\Collections\UserCollections|User[] $whereOwner
     *
     * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Company query()
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereDomain($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereInformation($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereOwnerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    class Company extends Model
    {
        /**
         * @return HasOne
         */
        public function systemUser(): HasOne
        {
            return $this->hasOne(SystemUser::class);
        }

        /**
         * @return BelongsToMany
         */
        public function users(): BelongsToMany
        {
            return $this->belongsToMany(User::class)->using(CompanyUser::class)->withPivot('status', 'is_owner');
        }

        /**
         * @return BelongsToMany
         */
        public function whereOwner(): BelongsToMany
        {
            return $this->users()->wherePivot('is_owner', true);
        }

        /**
         * @param User $user
         *
         * @return BelongsToMany
         */
        public function whereUser(User $user): BelongsToMany
        {
            return $this->users()->wherePivot('user_id', $user->id);
        }

        /**
         * @param User $user
         * @param bool $value
         *
         * @return int
         */
        public function updateOwnership(User $user, bool $value = false): int
        {
            return $this->users()->updateExistingPivot($user->id, ['is_owner' => $value]);
        }

        /**
         * @return HasMany
         */
        public function roles(): HasMany
        {
            return $this->hasMany(Role::class);
        }

        /**
         * @return HasMany
         */
        public function invites(): HasMany
        {
            return $this->hasMany(Invite::class);
        }
    }
