<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacksplashPrice extends Model
{
    protected $table = 'backsplash_prices';

    protected $fillable = [
        'backsplash_shape_id',
        'material_type_id',
        'price_lm_guest',
        'finished_side_price_lm_guest',
        'price_lm_business',
        'finished_side_price_lm_business',
        'min_height_mm',
        'max_height_mm',
        'status'
    ];

    // Relation to MaterialType
    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }
    // Relation to BacksplashShapes 
    public function backsplashShapes()
    {
        return $this->belongsTo(BacksplashShapes::class, 'backsplash_shape_id');
    }
}
