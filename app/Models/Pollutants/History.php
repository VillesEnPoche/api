<?php

namespace App\Models\Pollutants;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'pollutants_histories';

    protected $fillable = [
        'pollutant_id', 'type', 'var', 'date', 'value', 'alert',
    ];

    protected $casts = [
        'value' => 'float',
        'date' => 'date',
    ];

    public function pollutant()
    {
        return $this->belongsTo('App\Models\Pollutant');
    }
}
