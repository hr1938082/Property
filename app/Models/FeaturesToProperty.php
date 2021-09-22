<?php

namespace App\Models;

use App\View\Components\table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturesToProperty extends Model
{
    use HasFactory;

    protected $table = 'features_to_property';

    protected $primaryKey = 'id';

    protected $fillable = [
        'property_id',
        'features_id'
    ];

    public $timestamps = false;
}
