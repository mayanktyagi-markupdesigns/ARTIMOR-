<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacksplashShapes extends Model
{
    protected $table = 'backsplash_shapes';
   
    protected $fillable = [
        'name',
        'image',
        'dimension_fields',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'dimension_fields' => 'array'
    ];
}
