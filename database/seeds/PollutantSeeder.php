<?php

use App\Models\Pollutant;
use Illuminate\Database\Seeder;

class PollutantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pollutant::insert([
            [
                'name' => 'Ozone', 'acronym' => 'O3', 'cdf_name' => 'O3_composite', 'alerts' => json_encode([
                    0 => 48,
                    1 => 72,
                    2 => 96,
                    3 => 120,
                    4 => 150,
                ]),
            ],
            [
                'name' => 'Dioxyde d\'azote', 'acronym' => 'NO2', 'cdf_name' => 'NO2_composite', 'alerts' => json_encode([
                    0 => 28,
                    1 => 42,
                    2 => 56,
                    3 => 70,
                    4 => 100,
                ]),
            ],
            [
                'name' => 'Particules fines (10µm)', 'acronym' => 'PM10', 'cdf_name' => 'PM10_composite', 'alerts' => json_encode([
                    0 => 20,
                    1 => 30,
                    2 => 40,
                    3 => 50,
                    4 => 80,
                ]),
            ],
            [
                'name' => 'Particules fines (2.5µm)', 'acronym' => 'PM25', 'cdf_name' => 'PM25_composite', 'alerts' => json_encode([
                    0 => 14,
                    1 => 21,
                    2 => 28,
                    3 => 35,
                    4 => 60,
                ]),
            ],
        ]);
    }
}
