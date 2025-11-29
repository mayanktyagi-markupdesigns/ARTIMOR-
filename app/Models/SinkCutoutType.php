<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinkCutoutType extends Model
{
    protected $table = 'sink_cutout_types';

    protected $fillable = [
        'name',
        'status',
    ];
}
