<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialLayoutCategory extends Model
{
    protected $table = 'material_layout_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    // ✅ THIS WAS MISSING (CAUSE OF YOUR ERROR)
    public function groups()
    {
        return $this->hasMany(
            MaterialLayoutGroup::class,
            'layout_category_id'
        );
    }
}