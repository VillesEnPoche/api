<?php

namespace App\Models\Gas;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'gas_prices';

    protected $fillable = ['station_id', 'price', 'gas', 'created_at'];

    protected $casts = [
        'price' => 'float',
    ];

    public function station()
    {
        return $this->hasOne('App\Models\Gas\Station');
    }
}
