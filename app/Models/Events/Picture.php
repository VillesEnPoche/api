<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'events_pictures';

    protected $fillable = ['event_id', 'path', 'order'];

    public function event()
    {
        return $this->hasOne('App\Models\Event');
    }
}
