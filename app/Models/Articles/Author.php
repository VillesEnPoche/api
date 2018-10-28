<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'articles_authors';

    protected $fillable = ['partner_id', 'name', 'twitter'];
}
