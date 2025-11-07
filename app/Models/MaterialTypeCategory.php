<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTypeCategory extends Model
{
    protected $table = 'material_type_categories';

    protected $fillable = [
        'name',
        'status',
    ];
}
