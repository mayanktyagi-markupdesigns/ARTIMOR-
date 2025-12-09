<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sink extends Model
{
    protected $table = 'sinks';
    
    protected $fillable = [        
        'name',
        'price',
        'user_price',
        'sink_categorie_id',
        'internal_dimensions',
        'external_dimensions',
        'depth',
        'radius',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(SinkImage::class);
    }

    public function category()
    {
        return $this->belongsTo(SinkCategory::class, 'sink_categorie_id');
    }
}
