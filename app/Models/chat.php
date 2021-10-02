<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;

    protected $table = 'chat';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id1',
        'user_id2',
        'type',
        'is_live',
    ];

    public $timestamps = false;
}
