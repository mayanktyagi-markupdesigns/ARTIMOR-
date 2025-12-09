<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacksplashShapeSides extends Model
{
    protected $table = 'backsplash_shape_sides';

    protected $fillable = [
        'backsplash_shape_id',
        'side_name',
        'label',
        'is_finishable',
        'sort_order',
        'status'
    ];

    public function backsplashShape()
    {
        return $this->belongsTo(BacksplashShapes::class, 'backsplash_shape_id');
    }
}
