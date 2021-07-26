<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaynetGateway extends Model
{
    use HasFactory;

    protected $table = 'payment_gateway';

    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "type",
        "enable",
        "key_id",
        "key_secret",
        "bank_info"
    ];
    public $timestamps = false;
}
