<?php

use App\Models\Places\Type;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::insert([
            [
                'name' => 'Les services',
                'show' => 1,
            ],
            [
                'name' => 'Les commerces',
                'show' => 1,
            ],
            [
                'name' => 'Les magasins',
                'show' => 1,
            ],
            [
                'name' => 'Les restaurants',
                'show' => 1,
            ],
            [
                'name' => 'Bars et boîtes',
                'show' => 1,
            ],
            [
                'name' => 'Le Silex',
                'show' => 0,
            ],
        ]);

        // Services
        $type = Type::where('name', '=', 'Les services')->first();

        Type::insert([
            [
                'name' => 'Agence de Voyages',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Agence Immobilière',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Agence Intérim',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Assurance
Mutuelle',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Auto Ecole',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Banque',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Entretien Véhicule
Garage',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Institut de Beauté
Spa
Amincissement',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Pressing
Laverie
Cordonnerie',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Salon de Coiffure',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Salon de Toilettage',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Santé Laboratoire',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Tatoueur',
                'place_type_id_parent' => $type->id,
            ],
        ]);

        // Commerces
        $type = Type::where('name', '=', 'Les commerces')->first();

        Type::insert([
            [
                'name' => 'Boulangeries
Pâtisseries
Chocolateries',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Boucheries
Poissonneries
Traiteurs',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Fromageries
Produits Régionaux',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Vins
Spiritueux
Caves',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Fleuristes',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Bijouterie
Métaux Or',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Photographes',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Lutherie',
                'place_type_id_parent' => $type->id,
            ],
        ]);

        // Magasins
        $type = Type::where('name', '=', 'Les magasins')->first();

        Type::insert([
            [
                'name' => 'Alimentaire',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Ameublement
Décoration
Art de la table',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Brocante
Dépôt-Vente',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Cigarette Electronique',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Concessionnaire
Accessoires Véhicule',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Coutellerie
Armurerie',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Electroménager
Multimédia',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Jeux Vidéos
DVD
Jouets',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Librairie
Loisirs Créatifs
Papeterie',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Mode
Chaussures
Accessoires',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Optique
Audition
Santé',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Parfumerie
Matériel Esthétique',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Piscine
Extérieurs',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Puériculture
Enfants',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Sports',
                'place_type_id_parent' => $type->id,
            ],
            [
                'name' => 'Téléphonie
Réparation
Informatique',
                'place_type_id_parent' => $type->id,
            ],
        ]);

        // Silex
        $type = Type::where('name', '=', 'Le Silex')->first();
        $place = new \App\Models\Place();
        $place->name = 'Le Silex';
        $place->place_type_id = $type->id;
        $place->address = '7 Rue de l\'Île aux Plaisirs';
        $place->postal_code = '89000';
        $place->city = 'Auxerre';
        $place->phone = '03 86 40 95 40';
        $place->website = 'https://www.lesilex.fr';
        $place->position = new Point(47.7955859, 3.5807879);
        $place->premium = true;
        $place->save();
    }
}
