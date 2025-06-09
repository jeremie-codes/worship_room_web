<?php

namespace Database\Seeders;

use App\Models\Cotation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CotationSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::where('status', 'actif')->get();
        $annees = [2023, 2024];

        foreach ($annees as $annee) {
            // Mélange les utilisateurs pour garantir l'unicité
            $agentsACotter = $users->shuffle()->take(floor($users->count() * 0.7));

            $usedUserIds = collect();

            foreach ($agentsACotter as $agent) {
                // Sélectionner un user_id qui n’a pas encore été utilisé cette année
                $availableUsers = $users->whereNotIn('id', $usedUserIds);
                if ($availableUsers->isEmpty()) {
                    break; // plus d'utilisateurs disponibles pour cette année
                }

                $userId = $availableUsers->random()->id;
                $usedUserIds->push($userId);

                $noteCompetence = fake()->numberBetween(10, 20);
                $notePerformance = fake()->numberBetween(10, 20);
                $noteComportement = fake()->numberBetween(12, 20);
                $noteFinale = round(($noteCompetence + $notePerformance + $noteComportement) / 3);

                Cotation::create([
                    'agent_id' => $agent->id,
                    'user_id' => $userId,
                    'annee' => $annee,
                    'note_competence' => $noteCompetence,
                    'note_performance' => $notePerformance,
                    'note_comportement' => $noteComportement,
                    'note_finale' => $noteFinale,
                    'observations' => fake()->boolean(70) ? fake()->sentence() : null,
                    'status' => fake()->randomElement(['en_cours', 'valide', 'refuse']),
                    'commentaire_validateur' => fake()->boolean(50) ? fake()->sentence() : null,
                ]);
            }
        }
    }

}
