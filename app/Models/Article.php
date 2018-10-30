<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['partner_id', 'unique_id', 'title', 'distant', 'href', 'content', 'date', 'image'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function partner()
    {
        return $this->hasOne('App\Models\Articles\Partner');
    }
}
