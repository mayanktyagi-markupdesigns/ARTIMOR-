<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialLayout extends Model
{
   protected $table = 'material_layouts';
    
    protected $fillable = [
        'name',
        'layout_type',
        'image',
        'price',
        'status',
    ];
}
