<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $table = 'dimensions';
    
    protected $fillable = [
        'image',
        'height_cm',
        'width_cm',
        'status',
    ];
}
