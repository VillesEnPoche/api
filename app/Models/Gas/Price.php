<?php

namespace App\Models\Gas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    const EXPIRED_DAY = 5;
    protected $table = 'gas_prices';

    protected $fillable = ['station_id', 'price', 'gas', 'created_at'];

    protected $casts = [
        'price' => 'float',
    ];

    public function station()
    {
        return $this->hasOne('App\Models\Gas\Station');
    }

    public function lowPrice()
    {
        $price = self::where('gas', '=', $this->gas)
            ->orderBy('price', 'asc')
            ->whereDate('created_at', '>', Carbon::now()->subDays(self::EXPIRED_DAY))
            ->first();
        if (! is_null($price)) {
            return $price->price === $this->price;
        } else {
            return false;
        }
    }

    public function isExpired()
    {
        return $this->created_at < Carbon::now()->subDays(self::EXPIRED_DAY);
    }
}
