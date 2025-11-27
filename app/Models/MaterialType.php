<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $table = 'material_types';

    protected $fillable = [
        'name',
        'material_group_id',
        'status',
    ];

    public function group()
    {
        return $this->belongsTo(MaterialGroup::class, 'material_group_id');
    }
}
