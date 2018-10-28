<?php

namespace App\Models\Football;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'football_seasons';

    protected $fillable = ['fff_id', 'name', 'championship'];
}
