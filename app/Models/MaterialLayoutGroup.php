<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialLayoutGroup extends Model
{
    protected $table = 'material_layout_groups';

    protected $fillable = [
        'name',
        'layout_category_id',
        'status',
    ];

    public function layoutCategory()
    {
        return $this->belongsTo(MaterialLayoutCategory::class, 'layout_category_id');
    }
}
