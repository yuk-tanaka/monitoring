<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Notification;

/**
 * App\Eloquents\AccessNotification
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $slack
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereSlack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\AccessNotification whereUpdatedAt($value)
 */
class AccessNotification extends Model
{
    use Notifiable;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'slack',
    ];

    /**
     * @param $notification
     * @return string|null
     */
    public function routeNotificationForSlack($notification): ?string
    {
        return $this->slack;
    }
}
