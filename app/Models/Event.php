<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use SpatialTrait;

    protected $table = 'events';

    protected $fillable = ['place_id', 'name', 'start', 'end', 'description', 'position', 'premium', 'link', 'confirm'];

    protected $spatialFields = [
        'position',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Events\Picture');
    }
}
