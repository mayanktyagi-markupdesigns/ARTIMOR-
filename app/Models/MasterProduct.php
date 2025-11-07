<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProduct extends Model
{
    protected $table = 'master_products';
    
    protected $fillable = [
        'name',
        'material_id',
        'material_type_id',
        'material_layout_id',
        'material_edge_id',
        'back_wall_id',
        'sink_id',
        'cut_outs_id',
        'color_id',        
        'status',
    ];

    // Relationships
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class);
    }

    public function materialLayout()
    {
        return $this->belongsTo(MaterialLayout::class);
    }

    public function materialEdge()
    {
        return $this->belongsTo(MaterialEdge::class);
    }

    public function backWall()
    {
        return $this->belongsTo(BackWall::class);
    }

    public function sink()
    {
        return $this->belongsTo(Sink::class);
    }

    public function cutOut()
    {
        return $this->belongsTo(CutOuts::class, 'cut_outs_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    // Optional: Accessor for total price
    public function getTotalPriceAttribute()
    {
        return 
            ($this->material->price ?? 0) +
            ($this->materialType->price ?? 0) +
            ($this->materialLayout->price ?? 0) +
            ($this->materialEdge->price ?? 0) +
            ($this->backWall->price ?? 0) +
            ($this->sink->price ?? 0) +
            ($this->cutOut->price ?? 0);
    }

}
