<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ter extends Model
{
    protected $table = 'ters';

    protected $fillable = ['day', 'data', 'json'];

    protected $casts = [
        'json' => 'array',
    ];
}
