<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinkCategory extends Model
{
    protected $table = 'sink_categories';

    protected $fillable = [
        'name',
        'status',
    ];
}
