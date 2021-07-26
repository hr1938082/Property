<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankApproval extends Model
{
    use HasFactory;

    protected $table = 'bank_transfer_approval';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'image',
        'bank_info',
        'status'
    ];

    public $timestamps = false;
}
