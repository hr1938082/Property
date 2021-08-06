<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class currency extends Model
{
    use HasFactory;

    protected $table = 'currency';

    protected $primaryKey = 'id';

    protected $fillable = [
        'currency',
        'status'
    ];

    public $timestamps = false;
}
