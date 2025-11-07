<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialEdge extends Model
{
    protected $table = 'material_edges';
    
    protected $fillable = [
        'name',
        'price',
        'user_price',
        'image',
        'status',
    ];
}
