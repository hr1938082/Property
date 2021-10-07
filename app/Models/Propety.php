<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propety extends Model
{
    use HasFactory;

    // table name
    protected $table = 'properties';

    // primary key
    protected $primaryKey = 'id';

    //fillabe data
    protected $fillable = [
        'property_name',
        'bed_rooms',
        'bath_rooms',
        'toilets',
        'description',
        "currency_id",
        'user_id',
        'address_id',
        'rent',
        'rent_days',
        'year_build',
        'property_limit',
        'limit_status',
        'status'
    ];

    // timestamps not needed
    public $timestamps = false;
}
