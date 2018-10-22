<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pollutant extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'acronym', 'cdf_name'];

    protected $casts = [
        'alerts' => 'array',
    ];

    public function getAlert(float $alert)
    {
        foreach ($this->alerts as $level => $max) {
            if ($alert < $max) {
                return $level;
            }
        }
    }
}
