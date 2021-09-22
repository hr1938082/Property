<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsImages extends Model
{
    use HasFactory;

    protected $table = 'ads_images';

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
