<?php

    namespace Domain\Company\Models;

    use Domain\Company\Collections\CompanyCollections;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\ModelQueries\Company as CompanyModelQueries;
    use Domain\Invite\Models\Invite;
    use Domain\Role\Models\Role;
    use Domain\System\Models\SystemUser;
    use Domain\User\Collections\UserCollections;
    use Domain\User\Models\User;
    use Eloquent;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;

    /**
     * Domain\Company\Models\Company.
     *
     * @property int         $id
     * @property int|null    $owner_id
     * @property string      $name
     * @property string|null $email
     * @property string|null $domain
     * @property string|null $information
     * @property string      $status
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property-read Collection|Invite[] $invites
     * @property-read Collection|Role[] $roles
     * @property-read SystemUser|null $systemUser
     * @property-read User[]|UserCollections $users
     * @property-read User[]|UserCollections $whereOwner
     *
     * @method static CompanyCollections|static[] all($columns = ['*'])
     * @method static CompanyCollections|static[] get($columns = ['*'])
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
     * @mixin Eloquent
     */
    class Company extends CompanyModelQueries
    {
        protected $table = 'companies';

        protected $fillable = [
            CompanyTableMap::NAME,
            CompanyTableMap::EMAIL,
            CompanyTableMap::DOMAIN,
            CompanyTableMap::INFORMATION,
            CompanyTableMap::STATUS,
        ];

        /**
         * @param array $models
         *
         * @return CompanyCollections
         */
        public function newCollection(array $models = []): CompanyCollections
        {
            return new CompanyCollections($models);
        }
    }
