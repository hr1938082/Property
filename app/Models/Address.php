<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // table name
    protected $table = 'address';

    // primary key
    protected $primaryKey = 'id';

    // fillable data
    protected $fillable = [
        'country',
        'city',
        'state',
        'street',
        'zip_code',
    ];

    // timestamps not needed
    public $timestamps = false;
}
