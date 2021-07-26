<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable=[
        'bank_name',
        'account_name',
        'account_number',
        'country'
    ];

    public $timestamps = false;
}
