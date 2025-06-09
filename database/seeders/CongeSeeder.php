<?php

namespace Database\Seeders;

use App\Models\Conge;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CongeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'actif')->get();

        // Créer quelques demandes de congés
        for ($i = 0; $i < 15; $i++) {
            $agent = $users->random();
            $dateDebut = fake()->dateTimeBetween('now', '+3 months');
            $dateFin = Carbon::parse($dateDebut)->addDays(fake()->numberBetween(5, 21));
            $duree = Carbon::parse($dateDebut)->diffInDays($dateFin) + 1;

            Conge::create([
                'agent_id' => $agent->id,
                'user_id' => $users->random()->id, // Qui a créé la demande
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'duree' => $duree,
                'motif' => fake()->randomElement([
                    'Congé annuel',
                    'Congé de maternité',
                    'Congé maladie',
                    'Congé sans solde',
                    'Congé de formation',
                    'Congé exceptionnel',
                ]),
                'status' => fake()->randomElement([
                    'en_attente',
                    'approuve_directeur',
                    'traite_rh',
                    'valide_drh',
                    'refuse'
                ]),
                'commentaire_directeur' => fake()->boolean(60) ? fake()->sentence() : null,
                'commentaire_rh' => fake()->boolean(40) ? fake()->sentence() : null,
                'commentaire_drh' => fake()->boolean(30) ? fake()->sentence() : null,
            ]);
        }
    }
}
