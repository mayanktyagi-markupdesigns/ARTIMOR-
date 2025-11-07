<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class materialLayoutCategory extends Model
{
    protected $table = 'material_layout_categories';

    protected $fillable = [
        'name',
        'status',
    ];
}
