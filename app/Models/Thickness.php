<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thickness extends Model
{
    protected $table = 'thicknesses';

    protected $fillable = [
        'material_group_id',
        'material_type_id',
        'finish_id',
        'thickness_value',
        'is_massive',
        'can_be_laminated',
        'laminate_min',
        'laminate_max',
        'bussiness_price_m2',
        'guest_price_m2',
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

    public function finish()
    {
        return $this->belongsTo(Finish::class, 'finish_id');
    }    

}
