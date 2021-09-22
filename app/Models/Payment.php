<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $pimaryKey = 'id';

    protected $fillable = [
        'gateway_id',
        'amount',
        'user_id',
    ];
    public $timestamps = false;
}
