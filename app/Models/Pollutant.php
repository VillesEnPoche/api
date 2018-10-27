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

    public function getColor(int $alert)
    {
        $colors = [0 => '#00ccaa', '#99e600', '#ffff01', '#ffaa00', '#ff0000', '#7f0000'];

        return $colors[$alert];
    }

    public function getMax()
    {
        return $this->alerts[count($this->alerts) - 1];
    }
}
