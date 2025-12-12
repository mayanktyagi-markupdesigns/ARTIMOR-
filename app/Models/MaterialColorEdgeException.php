<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialColorEdgeException extends Model
{
    protected $table = 'material_color_edge_exceptions';

    protected $fillable = [
        'material_type_id',
        'color_id',
        'edge_profile_id',
        'thickness_id',
        'is_allowed',
        'override_price_per_lm',
        'override_guest_price_per_lm',
        'status',
    ];

    public function materialType()
    {
         return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
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
