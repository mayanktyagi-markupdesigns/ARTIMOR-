<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotations';
    use HasFactory;
    protected $fillable = [
        'material_id',
        'material_type_id',
        'layout_id',
        'dimensions',
        'edge_id',
        'edge_thickness',
        'edge_selected_edges',
        'back_wall_id',
        'back_wall_thickness',
        'back_wall_selected_edges',
        'sink_id',
        'sink_cutout',
        'sink_number',
        'cutout_id',
        'cutout_recess_type',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'delivery_option',
        'measurement_time',
        'promo_code',
        'total_price',
    ];

    protected $casts = [
        'dimensions' => 'json',
        'edge_selected_edges' => 'json',
        'back_wall_selected_edges' => 'json',
    ];
}
