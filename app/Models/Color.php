<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'material_group_id',
        'material_type_id',
        'status',
    ];

    public function materialGroup()
    {
        return $this->belongsTo(MaterialGroup::class, 'material_group_id');
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }
}
