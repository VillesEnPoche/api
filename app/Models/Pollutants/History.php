<?php

namespace App\Models\Pollutants;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'pollutants_histories';

    protected $fillable = [
        'pollutant_id', 'type', 'var', 'date', 'value', 'alert',
    ];
}
