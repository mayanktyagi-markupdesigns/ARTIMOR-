<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialLayout extends Model
{
   protected $table = 'material_layouts';
    
    protected $fillable = [
        'name',
        'material_layout_category_id',
        'image',
        'price',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(materialLayoutCategory::class, 'material_layout_category_id');
    }
}
