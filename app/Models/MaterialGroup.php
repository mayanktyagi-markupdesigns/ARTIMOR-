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
}
