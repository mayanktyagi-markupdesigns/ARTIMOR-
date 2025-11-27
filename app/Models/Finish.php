<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $table = 'finishes';

    protected $fillable = [
        'finish_name',
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
}
