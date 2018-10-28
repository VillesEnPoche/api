<?php

namespace App\Traits;

use App\Models\Place;

trait Silex
{
    /**
     * @return Place
     */
    private function _getPlace()
    {
        $place = Place::where('name', '=', self::PLACE_NAME)->first();
        if (is_null($place)) {
            new \Exception(self::PLACE_NAME . ' not found');
        }

        return $place;
    }
}
