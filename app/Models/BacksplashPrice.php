<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacksplashPrice extends Model
{
    protected $table = 'backsplash_prices';

    protected $fillable = [
        'backsplash_shape_id',
        'material_type_id',
        'thickness_id',
        'price_lm_guest',
        'finished_side_price_lm_guest',
        'price_lm_business',
        'finished_side_price_lm_business',
        'min_height_mm',
        'max_height_mm',
        'status'
    ];

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class);
    }

    public function thickness()
    {
        return $this->belongsTo(Thickness::class);
    }

    public function backsplashShape()
    {
        return $this->belongsTo(BacksplashShapes::class);
    }

}
