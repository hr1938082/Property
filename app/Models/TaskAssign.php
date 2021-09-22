<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
    use HasFactory;

    protected $table = "task_assign";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'date',
    ];
    public $timestamps = false;
}
