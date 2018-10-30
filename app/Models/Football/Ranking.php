<?php

namespace App\Models\Football;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'football_rankings';

    protected $fillable = ['season_id', 'team_id', 'team_name', 'position', 'evolution', 'played', 'points', 'win', 'drawn', 'lose', 'gf', 'ga', 'diff', 'day'];
}
