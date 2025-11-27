<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $table = 'finishes';

    protected $fillable = [
        'finish_name',
        'color_id',
        'status',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

}
