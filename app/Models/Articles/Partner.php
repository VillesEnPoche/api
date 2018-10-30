<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'articles_partners';

    protected $fillable = ['name', 'command', 'twitter', 'active'];

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function authors()
    {
        return $this->hasMany('App\Models\Articles\Author');
    }
}
