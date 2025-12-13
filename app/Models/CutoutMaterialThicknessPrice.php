<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutoutMaterialThicknessPrice extends Model
{
    protected $table = 'cutout_material_thickness_prices';
    
    protected $fillable = [        
        'cut_out_id',
        'material_type_id',
        'thickness_id',
        'thickness_value',
        'price_guest',
        'price_business',        
        'status',
    ];

    public function materialType()
    {
         return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    public function cutOuts()
    {
         return $this->belongsTo(CutOuts::class, 'cut_out_id');
    }

    // public function thickness()
    // {
    //     return $this->belongsTo(Thickness::class, 'thickness_id');
    // }
}
