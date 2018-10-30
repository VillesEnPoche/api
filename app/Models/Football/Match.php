<?php

namespace App\Models\Football;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'football_matchs';

    protected $fillable = ['season_id', 'fff_id', 't1_name', 't2_name', 't1_id', 't2_id', 't1_score', 't2_score', 'statut', 'day', 'date', 'diffuser', 'stade_name', 'twitter'];

    protected $casts = [
        'date' => 'datetime',
    ];
}
