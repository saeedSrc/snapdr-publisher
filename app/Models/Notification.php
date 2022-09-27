<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\NotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * @property int $id
 * @property string $to
 * @property string $name
 * @property string $message
 * @property int $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property bool $received
 * @property string $key
 *
 * @method static NotificationFactory factory(...$parameters)
 */
class Notification extends Model
{
    use HasFactory;
    protected $casts = [
        'received' => 'bool'
    ];

    public static function mapPushMethod(string $value): int
    {
        return match ($value) {
            config('notif.sms') => config('notif.sms_num'),
            config('notif.email') => config('notif.email_num'),
            default => throw new InvalidArgumentException()
        };
    }

}
