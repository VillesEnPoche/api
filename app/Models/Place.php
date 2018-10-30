<?php

namespace App\Models;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use SpatialTrait;

    protected $table = 'places';

    protected $fillable = ['place_type_id', 'name', 'address', 'postal_code', 'city', 'phone', 'website', 'timetable', 'position', 'premium'];

    protected $casts = [
        'timetable' => 'array',
    ];

    protected $spatialFields = [
        'position',
    ];

    public function pictures()
    {
        return $this->hasMany('App\Models\Places\Picture');
    }

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function type()
    {
        return $this->hasOne('App\Models\Places\Type');
    }
}
