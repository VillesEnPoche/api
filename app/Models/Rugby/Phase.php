<?php

namespace App\Models\Rugby;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $table = 'rugby_phases';

    protected $fillable = ['phase_id', 'championship', 'name'];
}
