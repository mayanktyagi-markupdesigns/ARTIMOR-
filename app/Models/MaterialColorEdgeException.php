<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialColorEdgeException extends Model
{
    protected $table = 'material_color_edge_exceptions';

    protected $fillable = [
        'color_id',
        'edge_profile_id',
        'thickness_id',
        'is_allowed',
        'price_per_lm_guest',
        'price_per_lm_business',
        'status',
    ];

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
