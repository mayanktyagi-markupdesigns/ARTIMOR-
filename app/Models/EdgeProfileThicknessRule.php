<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdgeProfileThicknessRule extends Model
{
    protected $table = 'edge_profile_thickness_rules';

    protected $fillable = [
        'edge_profile_id',
        'material_type_id',
        'thickness_id',
        'is_allowed',
        'price_per_lm_guest',
        'price_per_lm_business',
        'status',
    ];

    public function materialType()
    {
         return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    public function edgeProfile()
    {
        return $this->belongsTo(EdgeProfile::class, 'edge_profile_id');
    }

    public function thickness()
    {
        return $this->belongsTo(Thickness::class, 'thickness_id');
    }
}
