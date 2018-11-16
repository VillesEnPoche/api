<?php

namespace App\Models\Theaters\Movies;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $table = 'theaters_movies_times';

    protected $fillable = ['movie_id', 'date', 'is_3d', 'is_original', 'lang'];

    protected $casts = [
        'date' => 'datetime',
        'is_3d' => 'boolean',
        'is_original' => 'boolean',
    ];

    public function movie()
    {
        return $this->hasOne('App\Models\Theaters\Movie');
    }
}
