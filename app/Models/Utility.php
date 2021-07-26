<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    protected $table ='utility';

    protected $primaryKey ='id';

    protected $fillable = [
        'property_id',
        'utility_name',
        'period'
    ];

    public $timestamps = false;
}
