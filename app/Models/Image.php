<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // primary key
    protected $primaryKey = 'id';

    // fillable data
    protected $fillable = [
        'property_id',
        'name_dir',
    ];

    // timestamps not needed
    public  $timestamps = false;
}
