<?php

namespace Domain\Git\Models;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Domain\Git\Models\GitAccount.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property GitServiceTypes                 $service
 * @property string                          $username
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Git\Models\GitAccountAccessTokens|null $accessToken
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccount whereUsername($value)
 *
 * @mixin \Eloquent
 */
class GitAccount extends Model
{
    protected $table = 'git_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        GitAccountTableMap::USER_ID,
        GitAccountTableMap::SERVICE,
        GitAccountTableMap::USERNAME,
    ];

    protected $casts = [
        GitAccountTableMap::SERVICE => GitServiceTypes::class,
    ];

    /**
     * @return HasOne
     */
    public function accessToken(): HasOne
    {
        return $this->hasOne(GitAccountAccessTokens::class);
    }
}
