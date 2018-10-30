<?php

namespace App\Models\Gas;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'gas_stations';

    protected $fillable = ['pvid', 'name', 'address', 'city'];

    public function prices()
    {
        return $this->hasMany('App\Models\Gas\Price');
    }
}
