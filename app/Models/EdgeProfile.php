<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdgeProfile extends Model
{
    protected $table = 'edge_profiles';

    protected $fillable = [
        'name',
        'status',
    ];
}
