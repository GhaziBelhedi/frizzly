<?php

namespace Database\Seeders;

use App\Models\LibraryPdf;
use Illuminate\Database\Seeder;

class LibraryPdfSeeder extends Seeder
{
    public function run(): void
    {
        $pdfs = [
            [
                'title'       => 'Guide pédagogique Frizzly Kit — Édition 2026',
                'description' => 'Manuel complet 120 pages pour enseignants incluant toutes les activités, grilles d\'évaluation et protocoles d\'utilisation du Frizzly Kit en classe.',
                'category'    => 'Pédagogie',
                'file'        => 'library/guide-pedagogique-2026.pdf',
                'file_size'   => 4200000,
            ],
            [
                'title'       => 'Compétences entrepreneuriales — Module 1 : Autonomie',
                'description' => 'Support de cours du premier module sur les compétences clés de l\'entrepreneuriat chez les jeunes. Inclut 15 fiches activités et grilles de progression.',
                'category'    => 'Formation',
                'file'        => 'library/module1-autonomie.pdf',
                'file_size'   => 2100000,
            ],
            [
                'title'       => 'Compétences entrepreneuriales — Module 2 : Créativité',
                'description' => 'Support du deuxième module centré sur le développement de la créativité et de l\'innovation pédagogique. 12 ateliers pratiques.',
                'category'    => 'Formation',
                'file'        => 'library/module2-creativite.pdf',
                'file_size'   => 1850000,
            ],
            [
                'title'       => 'Évaluation diagnostique — CP & CE1',
                'description' => 'Fiches d\'évaluation adaptées aux niveaux CP et CE1 pour un diagnostic initial des compétences sociales et entrepreneuriales des élèves.',
                'category'    => 'Évaluation',
                'file'        => 'library/eval-diagnostique-cp-ce1.pdf',
                'file_size'   => 920000,
            ],
            [
                'title'       => 'Carnet de progression enseignant — Suivi annuel',
                'description' => 'Outil de suivi personnel des progrès et objectifs pédagogiques sur l\'année scolaire. Comprend des indicateurs de progression et espaces de réflexion.',
                'category'    => 'Outils',
                'file'        => 'library/carnet-progression.pdf',
                'file_size'   => 680000,
            ],
            [
                'title'       => 'Programme certifiant Frizzly — Syllabus complet',
                'description' => 'Description détaillée du programme certifiant avec les 4 modules, les objectifs de formation, les modalités d\'évaluation et la certification finale.',
                'category'    => 'Certification',
                'file'        => 'library/syllabus-certifiant.pdf',
                'file_size'   => 1350000,
            ],
            [
                'title'       => 'Fiches activités — Cartes Socita (24 activités)',
                'description' => 'Collection complète des 24 fiches activités pratiques pour utiliser les cartes Socita en classe de manière progressive, du CP au CM2.',
                'category'    => 'Pédagogie',
                'file'        => 'library/fiches-activites-socita.pdf',
                'file_size'   => 3800000,
            ],
            [
                'title'       => 'Référentiel des 9 compétences entrepreneuriales',
                'description' => 'Document de référence définissant les 9 compétences clés de la plateforme Frizzly : descripteurs, indicateurs de maîtrise et progressions attendues.',
                'category'    => 'Référentiel',
                'file'        => 'library/referentiel-9-competences.pdf',
                'file_size'   => 1100000,
            ],
        ];

        foreach ($pdfs as $data) {
            LibraryPdf::firstOrCreate(['title' => $data['title']], $data);
        }
    }
}
