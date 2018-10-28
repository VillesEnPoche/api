<?php

use App\Models\Articles\Partner;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lyonne = Partner::create([
            'name' => 'L\'Yonne Républicaine',
            'twitter' => 'lyonne_fr',
            'command' => 'import:news:yonnerepublicaine',
        ]);

        $authors = [
            'Antonin Bisson' => 'antoninbisson',
            'Vincent Thomas' => 'Vincent__Thomas',
            'Clara Guilliet' => 'claragllt',
            'Cécilia Lacour' => 'CeciliaLcr',
            'Laurenne Jannot' => 'Lau_Jnt',
            'Romain Blanc' => 'RomainBlanc',
            'Ludivine Tomasi' => 'luditomasi',
            'Willem van de Kraats' => 'wvdk',
            'Ludovic Berger' => 'berger_ludovic',
            'Marie Coreixas' => 'mariecoreixas',
            'Cécile Carton' => 'cecilecarton',
            'Véronique Sellès' => 'veroselles',
            'Franck Morales' => 'FrMorales4',
            'Sophie Thomas' => 'STYonneRep',
            'Stéphanie Zeimet' => 'StephanieZeimet',
            'Nora Gutting' => 'noragutting',
            'Mélanie Marois' => 'melimarois',
            'Florent Leybros' => 'Flo_Leyb',
            'Julien Ben Bouali' => 'ju_benbouali',
            'Cindy Bonnaud' => 'cib_buen',
            'Lydia Berthomieu' => 'LydiaBerthomieu',
            'Hugo Borrel' => 'HugoBorrel',
            'Marc Charasson' => 'marccharasson',
        ];

        foreach ($authors as $name => $twitter) {
            \App\Models\Articles\Author::create([
                'partner_id' => $lyonne->id,
                'name' => $name,
                'twitter' => $twitter,
            ]);
        }
    }
}
