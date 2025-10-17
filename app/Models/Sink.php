<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sink extends Model
{
    protected $table = 'sinks';
    
    protected $fillable = [        
        'name',
        'price',
        'series_type',
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
}
