<?php

namespace Domain\Git\Models;

use Domain\Git\Mappings\GitAccountAccessTokensTableMap;
use Illuminate\Database\Eloquent\Model;

/**
 * Domain\Git\Models\GitAccountAccessTokens
 *
 * @property int $id
 * @property int $git_account_id
 * @property string $token
 * @property string|null $refresh_token
 * @property int|null $expires_in
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens query()
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereGitAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GitAccountAccessTokens whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GitAccountAccessTokens extends Model
{
    protected $table = 'git_account_access_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        GitAccountAccessTokensTableMap::TOKEN,
        GitAccountAccessTokensTableMap::REFRESH_TOKEN,
        GitAccountAccessTokensTableMap::EXPIRES_IN,
    ];
}
