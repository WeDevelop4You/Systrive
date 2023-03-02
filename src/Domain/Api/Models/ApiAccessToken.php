<?php

namespace Domain\Api\Models;

use Domain\Api\Enums\ApiAccessTokenRestrictionType;
use Domain\Api\Mappings\ApiAccessTokenTableMap;
use Eloquent;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Domain\Api\Models\ApiAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property ApiAccessTokenRestrictionType $restriction
 * @property array|null $stateful
 * @property mixed|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereRestriction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereStateful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiAccessToken whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ApiAccessToken extends PersonalAccessToken
{
    protected $table = 'api_access_tokens';

    protected $fillable = [
        ApiAccessTokenTableMap::COL_NAME,
        ApiAccessTokenTableMap::COL_TOKEN,
        ApiAccessTokenTableMap::COL_STATEFUL,
        ApiAccessTokenTableMap::COL_ABILITIES,
        ApiAccessTokenTableMap::COL_RESTRICTION,
        ApiAccessTokenTableMap::COL_LAST_USED_AT,
        ApiAccessTokenTableMap::COL_TOKENABLE_ID,
        ApiAccessTokenTableMap::COL_TOKENABLE_TYPE
    ];

    protected $casts = [
        ApiAccessTokenTableMap::COL_STATEFUL => 'array',
        ApiAccessTokenTableMap::COL_RESTRICTION => ApiAccessTokenRestrictionType::class
    ];
}
