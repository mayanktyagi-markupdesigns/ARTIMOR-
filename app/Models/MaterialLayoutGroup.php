<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLayoutGroup extends Model
{
    use HasFactory;

    protected $table = 'material_layout_groups';

    protected $fillable = [
        'name',
        'layout_category_id',
        'status',
    ];

    public function layoutCategory()
    {
        return $this->belongsTo(
            MaterialLayoutCategory::class,
            'layout_category_id'
        );
    }

    // ✅ REQUIRED — THIS IS THE METHOD LARAVEL CANNOT FIND
    public function shapes()
    {
        return $this->hasMany(
            MaterialLayoutShape::class,
            'layout_group_id'
        );
    }

}
