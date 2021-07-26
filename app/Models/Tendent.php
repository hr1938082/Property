<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tendent extends Model
{
    use HasFactory;
    protected $table = 'tendent_to_property';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tendent_id',
        'property_id',
        'date',
        'status',
        'is_live'
    ];

    public $timestamps = false;
}
