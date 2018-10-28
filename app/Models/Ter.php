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

    /**
     * @return mixed
     */
    public static function departures()
    {
        return self::where('data', '=', 'departures')->orderBy('day', 'desc')->first();
    }

    /**
     * @return mixed
     */
    public static function arrivals()
    {
        return self::where('data', '=', 'arrivals')->orderBy('day', 'desc')->first();
    }
}
