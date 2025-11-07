<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $table = 'material_types';

    protected $fillable = [
        'name',
        'material_type_category_id',
        'image',
        'price',
        'status',
    ];

    // ✅ Correct relationship
    public function category()
    {
        return $this->belongsTo(MaterialTypeCategory::class, 'material_type_category_id');
    }
}