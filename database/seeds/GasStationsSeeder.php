<?php

use Illuminate\Database\Seeder;

class GasStationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Gas\Station::insert([
            [
                'pvid' => 89000001,
                'name' => 'Géant',
                'address' => 'C.C. Clairons - Avenue Haussmann',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000002,
                'name' => 'Atac',
                'address' => '"Les Vaures" - 9, rue de Preuilly - D163',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000003,
                'name' => 'Bi1',
                'address' => 'Rue de Bruxelles',
                'city' => 'Saint-Georges-sur-Baulche',
            ],
            [
                'pvid' => 89000004,
                'name' => 'Total',
                'address' => '16-22, boulevard Vaulabelle - N151',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000005,
                'name' => 'Total Access',
                'address' => '2, avenue Jean Mermoz - N77',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000007,
                'name' => 'Esso Express',
                'address' => 'Boulevard Gallieni - D234',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000008,
                'name' => 'Leclerc',
                'address' => '14-16, avenue Jean Jaurès - N77',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000009,
                'name' => 'Intermarché',
                'address' => 'Quartier Saint-Siméon - C.C. - Boulevard de Verdun - D234',
                'city' => 'Auxerre',
            ],
            [
                'pvid' => 89000011,
                'name' => 'Carrefour market',
                'address' => '97/99, route de Saint-Georges - D89',
                'city' => 'Auxerre',
            ],
        ]);
    }
}
