<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutOutsImage extends Model
{
    protected $table = 'cut_outs_images';
    
    protected $fillable = [        
        'cut_out_id',
        'image',
        'status',
    ];
}
