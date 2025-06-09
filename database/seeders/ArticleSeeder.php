<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            // Fournitures de bureau
            ['nom' => 'Papier A4 80g', 'code' => 'PAP001', 'categorie' => 'Papeterie', 'quantite' => 150, 'seuil_alerte' => 20],
            ['nom' => 'Stylos bleus', 'code' => 'STY001', 'categorie' => 'Papeterie', 'quantite' => 85, 'seuil_alerte' => 15],
            ['nom' => 'Classeurs A4', 'code' => 'CLA001', 'categorie' => 'Papeterie', 'quantite' => 45, 'seuil_alerte' => 10],
            ['nom' => 'Agrafeuses', 'code' => 'AGR001', 'categorie' => 'Papeterie', 'quantite' => 12, 'seuil_alerte' => 3],
            ['nom' => 'Perforatrices', 'code' => 'PER001', 'categorie' => 'Papeterie', 'quantite' => 8, 'seuil_alerte' => 2],

            // Matériel informatique
            ['nom' => 'Souris optique', 'code' => 'SOU001', 'categorie' => 'Informatique', 'quantite' => 25, 'seuil_alerte' => 5],
            ['nom' => 'Clavier AZERTY', 'code' => 'CLA002', 'categorie' => 'Informatique', 'quantite' => 18, 'seuil_alerte' => 5],
            ['nom' => 'Écran 22 pouces', 'code' => 'ECR001', 'categorie' => 'Informatique', 'quantite' => 10, 'seuil_alerte' => 3],
            ['nom' => 'Câble HDMI', 'code' => 'CAB001', 'categorie' => 'Informatique', 'quantite' => 15, 'seuil_alerte' => 5],
            ['nom' => 'Disque dur externe 1To', 'code' => 'DIS001', 'categorie' => 'Informatique', 'quantite' => 8, 'seuil_alerte' => 2],

            // Produits d\'entretien
            ['nom' => 'Détergent multi-usage', 'code' => 'DET001', 'categorie' => 'Entretien', 'quantite' => 30, 'seuil_alerte' => 8],
            ['nom' => 'Papier toilette', 'code' => 'PAP002', 'categorie' => 'Entretien', 'quantite' => 120, 'seuil_alerte' => 25],
            ['nom' => 'Savon liquide', 'code' => 'SAV001', 'categorie' => 'Entretien', 'quantite' => 20, 'seuil_alerte' => 5],
            ['nom' => 'Sacs poubelle', 'code' => 'SAC001', 'categorie' => 'Entretien', 'quantite' => 5, 'seuil_alerte' => 10], // En rupture

            // Mobilier
            ['nom' => 'Chaise de bureau', 'code' => 'CHA001', 'categorie' => 'Mobilier', 'quantite' => 6, 'seuil_alerte' => 2],
            ['nom' => 'Bureau 120x80cm', 'code' => 'BUR001', 'categorie' => 'Mobilier', 'quantite' => 3, 'seuil_alerte' => 1],
            ['nom' => 'Armoire métallique', 'code' => 'ARM001', 'categorie' => 'Mobilier', 'quantite' => 2, 'seuil_alerte' => 1],

            // Consommables
            ['nom' => 'Cartouche encre noire', 'code' => 'CAR001', 'categorie' => 'Consommables', 'quantite' => 12, 'seuil_alerte' => 3],
            ['nom' => 'Cartouche encre couleur', 'code' => 'CAR002', 'categorie' => 'Consommables', 'quantite' => 8, 'seuil_alerte' => 2],
            ['nom' => 'Toner laser', 'code' => 'TON001', 'categorie' => 'Consommables', 'quantite' => 0, 'seuil_alerte' => 2], // En rupture
        ];

        foreach ($articles as $article) {
            Article::create([
                ...$article,
                'description' => 'Article de ' . strtolower($article['categorie']) . ' pour les besoins du service',
            ]);
        }
    }
}
