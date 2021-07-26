<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentPay extends Model
{
    use HasFactory;
    protected $table = 'rent_pay';
    protected $primaryKey = 'id';

    protected $fillable = [
        'rent_id',
        'amount_paid',
        'date',
        'late'
    ];

    public $timestamps = false;
}
