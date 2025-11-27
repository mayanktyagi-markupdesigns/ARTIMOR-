<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thickness extends Model
{
    protected $table = 'thicknesses';

    protected $fillable = [
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

    public function finish()
    {
        return $this->belongsTo(Finish::class, 'finish_id');
    }

    

}
