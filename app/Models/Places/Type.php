<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'places_types';

    protected $fillable = ['name', 'path', 'place_type_id_parent', 'show'];

    public function places()
    {
        return $this->hasMany('App\Models\Place');
    }
}
