<?php

namespace App\Models\Rugby;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'rugby_matchs';

    protected $fillable = ['ffr_id', 'phase_id', 'date', 'statut', 't1_score', 't2_score', 't1_name', 't2_name', 't1_city', 't2_city', 'terrain'];

    protected $casts = [
        'date' => 'datetime',
    ];
}
