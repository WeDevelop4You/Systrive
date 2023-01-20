<?php

namespace Domain\Translation\Models;

use WeDevelop4You\TranslationFinder\Models\TranslationKey as TranslationKeyWeDevelop4You;

/**
 * Domain\Translation\Models\TranslationKey.
 *
 * @property int                             $id
 * @property string                          $environment
 * @property string                          $group
 * @property string                          $key
 * @property mixed|null                      $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WeDevelop4You\TranslationFinder\Models\TranslationSource[] $sources
 * @property-read \Illuminate\Database\Eloquent\Collection|\WeDevelop4You\TranslationFinder\Models\Translation[] $translations
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereEnvironment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationKey whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class TranslationKey extends TranslationKeyWeDevelop4You
{
}
