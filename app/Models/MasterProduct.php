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

    // Optional: Accessor for total price
    public function getTotalPriceAttribute()
    {
        return 
            ($this->material->price ?? 0) +
            ($this->materialType->price ?? 0) +
            ($this->materialLayout->price ?? 0) +
            ($this->materialEdge->price ?? 0);
    }

}
