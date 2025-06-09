<?php

namespace Database\Seeders;

use App\Models\DemandeFourniture;
use App\Models\Article;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemandeFournitureSeeder extends Seeder
{
    public function run(): void
    {
        $articles = Article::all();
        $services = Service::all();
        $users = User::where('status', 'actif')->get();

        if ($articles->isEmpty() || $services->isEmpty() || $users->isEmpty()) {
            $this->command->warn('⚠️ Impossible de générer les demandes de fournitures : il manque des articles, services ou utilisateurs actifs.');
            return;
        }

        for ($i = 0; $i < 25; $i++) {
            $article = $articles->random();
            $maxQuantite = max(1, min(10, $article->quantite + 5));
            $quantite = fake()->numberBetween(1, $maxQuantite);

            DemandeFourniture::create([
                'service_id' => $services->random()->id,
                'user_id' => $users->random()->id,
                'article_id' => $article->id,
                'quantite' => $quantite,
                'niveau_urgence' => fake()->randomElement(['normal', 'urgent', 'tres_urgent']),
                'motif' => fake()->randomElement([
                    'Renouvellement du stock',
                    'Nouveau projet',
                    'Remplacement matériel défaillant',
                    'Extension équipe',
                    'Formation du personnel',
                    'Maintenance préventive',
                ]),
                'status' => $status = fake()->randomElement(['en_attente', 'approuve', 'refuse', 'livre']),
                'commentaire_validateur' => fake()->boolean(60) ? fake()->sentence() : null,
                'date_livraison' => in_array($status, ['livre']) ? fake()->dateTimeBetween('-1 month', 'now') : null,
            ]);
        }
    }
}

