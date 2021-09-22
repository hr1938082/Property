<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adds extends Model
{
    use HasFactory;

    protected $table = 'adds';

    // primary key
    protected $primaryKey = 'id';

    //fillabe data
    protected $fillable = [
        'name',
        'bed_rooms',
        'bath_rooms',
        'toilets',
        'description',
        "currency_id",
        'address_id',
        'rent',
        "for_type",
        'year_build',
        'type',
        'owner',
        'owner_email',
        'owner_phone',
        'status',
        'approval'
    ];

    // timestamps not needed
    public $timestamps = false;
}
