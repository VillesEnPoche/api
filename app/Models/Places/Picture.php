<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'places_pictures';

    protected $fillable = ['place_id', 'path', 'order'];

    public function place()
    {
        return $this->hasOne('App\Models\Place');
    }
}
