<?php

namespace App\Models\Ters;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'ters_alerts';

    protected $fillable = ['date', 'content', 'type', 'obj'];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * @return mixed
     */
    public static function today()
    {
        return self::where('date', '=', date('Y-m-d'))->get();
    }
}
