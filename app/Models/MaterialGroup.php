<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialGroup extends Model
{
    protected $table = 'material_groups';

    protected $fillable = [
        'name',
        'status',
    ];

    public function types()
    {
        return $this->hasMany(MaterialType::class, 'material_group_id');
    }

}
