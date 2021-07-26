<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $table = 'rent';

    protected $primaryKey = 'id';

    protected $fillable = [
        'property_id',
        'user_id',
        'amount',
        'split'
    ];

    public $timestamps = false;
}
