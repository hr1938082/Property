<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersubscription extends Model
{
    use HasFactory;

    protected $table = 'user_subscriptions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'payment_id',
        'expiry_date',
        'status'
    ];

    public $timestamps = false;
}
