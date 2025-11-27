<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialLayoutShape extends Model
{
    protected $table = 'material_layout_shapes';

    protected $fillable = [
        'name',
        'layout_group_id',
        'image',
        'status',
    ];

    public function layoutGroup()
    {
        return $this->belongsTo(MaterialLayoutGroup::class, 'layout_group_id');
    }
}
