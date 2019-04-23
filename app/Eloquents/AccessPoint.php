<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\AccessPoint
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessPoint whereUrl($value)
 */
class AccessPoint extends Model
{
    /** @var array */
    protected $fillable = [
        'name',
        'url',
    ];
}
