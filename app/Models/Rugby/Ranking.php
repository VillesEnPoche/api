<?php

namespace App\Models\Rugby;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'rugby_rankings';

    protected $fillable = ['phase_id', 'poule_id', 'team_id', 'name', 'position', 'regulationPointsTerrain', 'pointTerrain', 'joues', 'gagnes', 'nuls', 'perdus', 'pointsDeMarqueAquis', 'pointsDeMarqueConcedes', 'goalAverage', 'essaisMarques', 'essaisConcedes', 'bonusOffensif', 'bonusDefensif'];
}
