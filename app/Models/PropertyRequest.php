<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRequest extends Model
{
    use HasFactory;

    protected $table = 'preperty_request';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tendent_id',
        'property_id',
        'date',
        'status'
    ];

    public $timestamps = false;
}
