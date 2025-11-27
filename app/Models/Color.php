<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'material_type_id',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }
}
