<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'Property_id',
        'User_id',
        'message',
        'image_name',
        'base64',
        'time'
    ];

    public $timestamps = false;
}
