<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityPaid extends Model
{
    use HasFactory;

    protected $table ='utility_paid';

    protected $primaryKey ='id';

    protected $fillable = [
        'utility_id',
        'user_id',
        'total_amount',
        'paid_by_user',
        'is_split',
        'date'
    ];

    public $timestamps = false;
}
