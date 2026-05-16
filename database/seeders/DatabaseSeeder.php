<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,       // Utilisateurs (admin + enseignants + users)
            ProductSeeder::class,    // Produits du catalogue
            OrderSeeder::class,      // Commandes (dépend de Product)
            MessageSeeder::class,    // Messages de contact
            LibraryPdfSeeder::class, // PDFs de la bibliothèque
            TestResultSeeder::class, // Résultats de tests manuels (dépend de User)
            QuizSeeder::class,       // QCMs + Questions + Réponses + Résultats
        ]);
    }
}
