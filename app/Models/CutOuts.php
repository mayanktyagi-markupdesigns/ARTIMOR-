<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutOuts extends Model
{
    protected $table = 'cut_outs';
    
    protected $fillable = [        
        'name',
        'price',
        'cut_outs_category_id',
        'description',        
        'status',
    ];

    public function images()
    {
        return $this->hasMany(CutOutsImage::class, 'cut_out_id');
    }

    public function category()
    {
        return $this->belongsTo(CutOutsCategory::class, 'cut_outs_category_id');
    }
}
