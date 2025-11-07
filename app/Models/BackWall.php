<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackWall extends Model
{
    protected $table = 'back_walls';
    
    protected $fillable = [
        'name',
        'image',
        'price',
        'user_price',
        'status',
    ];
}
