<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'period',
        'features',
        'amount',
        'status'
    ];

    public $timestamps = false;
}
