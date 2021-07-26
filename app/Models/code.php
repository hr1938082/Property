<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class code extends Model
{
    use HasFactory;

    protected $table = 'varification_code';

    protected $primaryKey = 'id';

    protected $fillable = [
        "user_id",
        "code",
        "date_time",
        "status"
    ];

    public $timestamps = false;
}
