<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutOuts extends Model
{
    protected $table = 'cut_outs';
    
    protected $fillable = [        
        'name',
        'price',
        'series_type',
        'description',        
        'status',
    ];

    public function images()
    {
        return $this->hasMany(CutOutsImage::class, 'cut_out_id');
    }
}
