<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinkImage extends Model
{
    protected $table = 'sink_images';
    
    protected $fillable = [        
        'sink_id',
        'image',
        'status',
    ];
}
