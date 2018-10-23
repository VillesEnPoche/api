<?php

namespace App\Models\Ters;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'ters_details';

    protected $fillable = ['number', 'json'];

    protected $casts = [
        'json' => 'array',
    ];
}
