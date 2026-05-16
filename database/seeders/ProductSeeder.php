<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title'       => 'Frizzly Kit Essentiel',
                'description' => 'Le kit de démarrage idéal pour intégrer Frizzly en classe. Comprend les 60 cartes Socita, le guide pédagogique complet et les fiches activités.',
                'price'       => 49.00,
                'stock'       => 35,
                'category'    => 'Kit pédagogique',
                'active'      => true,
            ],
            [
                'title'       => 'Frizzly Kit Premium',
                'description' => 'Le kit complet avec certification enseignant incluse, toutes les ressources numériques et l\'accès au programme certifiant en ligne pendant 12 mois.',
                'price'       => 98.00,
                'stock'       => 12,
                'category'    => 'Kit pédagogique',
                'active'      => true,
            ],
            [
                'title'       => 'Cartes Socita — Pack 60',
                'description' => '60 cartes Socita supplémentaires pour enrichir les activités en groupe. Idéal pour les classes de plus de 30 élèves ou pour les formations d\'équipes.',
                'price'       => 29.00,
                'stock'       => 0,
                'category'    => 'Matériel',
                'active'      => false,
            ],
            [
                'title'       => 'Guide Pédagogique Premium',
                'description' => 'Guide avancé 180 pages pour enseignants certifiés. Inclut 120 activités supplémentaires, grilles d\'évaluation et fiches de différenciation pédagogique.',
                'price'       => 35.00,
                'stock'       => 28,
                'category'    => 'Guide',
                'active'      => true,
            ],
            [
                'title'       => 'Formation en ligne — Module certifiant',
                'description' => 'Accès 12 mois à la plateforme de formation certifiante Frizzly. 4 modules progressifs, 40h de contenu, évaluations et certification officielle.',
                'price'       => 120.00,
                'stock'       => 999,
                'category'    => 'Formation',
                'active'      => true,
            ],
            [
                'title'       => 'Pack École — 10 kits',
                'description' => 'Pack spécial établissements scolaires : 10 kits essentiels + formation initiale de 2h pour l\'équipe pédagogique. Prix dégressif par rapport à l\'achat individuel.',
                'price'       => 420.00,
                'stock'       => 8,
                'category'    => 'Pack école',
                'active'      => true,
            ],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(['title' => $data['title']], $data);
        }
    }
}
