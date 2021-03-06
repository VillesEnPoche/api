<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PollutantSeeder::class);
        $this->call(GasStationsSeeder::class);
        $this->call(PlacesSeeder::class);
        $this->call(ArticlesSeeder::class);
    }
}
