<?php

namespace App\Models\Theaters;

use App\Models\Theaters\Movies\Time;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'theaters_movies';

    protected $fillable = ['code_id', 'title', 'actors', 'directors', 'genres', 'synopsis', 'path_poster', 'path_trailer', 'runtime', 'rating', 'release'];

    protected $casts = [
        'actors' => 'array',
        'directors' => 'array',
        'genres' => 'array',
        'release' => 'date',
    ];

    public function times()
    {
        return $this->hasMany('App\Models\Theaters\Movies\Time');
    }

    public function next()
    {
        return Time::where('movie_id', '=', $this->id)->where('date', '>', Carbon::now())->orderBy('date', 'asc')->first();
    }
}
