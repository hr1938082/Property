<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationReadUnread extends Model
{
    use HasFactory;

    protected $table = 'notifications_read_unread';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'notification_id',
    ];

    public $timestamps = false;
}
