<?php

namespace Database\Seeders;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MissionSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::where('status', 'actif')->get();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ Aucun utilisateur actif trouvé pour générer des missions.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $agent = $users->random();
            $nombreJours = fake()->numberBetween(1, 10);
            $dateDebut = fake()->dateTimeBetween('-2 months', '+2 months');
            $dateFin = Carbon::parse($dateDebut)->addDays($nombreJours - 1);

            $status = fake()->randomElement(['en_preparation', 'en_cours', 'terminee', 'annulee']);

            Mission::create([
                'reference' => 'MSN-' . now()->format('YmdHis') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'agent_id' => $agent->id,
                'user_id' => $users->random()->id,
                'lieu' => fake()->randomElement([
                    'Bouaké', 'Yamoussoukro', 'San Pedro', 'Korhogo', 'Daloa', 'Man', 'Gagnoa', 'Divo',
                ]),
                'objet' => fake()->randomElement([
                    'Formation technique du personnel',
                    'Audit des installations',
                    'Supervision des travaux',
                    'Réunion avec les partenaires',
                    'Évaluation des projets',
                    'Mission de contrôle',
                    'Formation des agents locaux',
                    'Inspection des équipements',
                ]),
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'duree' => $nombreJours,
                'frais_mission' => fake()->numberBetween(50000, 500000),
                'status' => $status,
                'observations' => fake()->boolean(60) ? fake()->sentence() : null,
                'rapport' => $status === 'terminee' ? fake()->paragraph() : null,
            ]);
        }
    }

}
