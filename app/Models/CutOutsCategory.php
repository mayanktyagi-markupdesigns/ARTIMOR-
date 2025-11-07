<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutOutsCategory extends Model
{
    protected $table = 'cut_outs_categories';

    protected $fillable = [
        'name',
        'status',
    ];
}
