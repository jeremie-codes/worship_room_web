<?php

namespace Database\Seeders;

use App\Models\Courrier;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourrierSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();
        $users = User::where('status', 'actif')->get();

        for ($i = 0; $i < 30; $i++) {
            $type = fake()->randomElement(['entrant', 'sortant', 'interne']);
            $dateCreation = fake()->dateTimeBetween('-3 months', 'now');

            Courrier::create([
                'reference' => $this->genererReference($type, $i + 1),
                'type' => $type,
                'motif' => fake()->randomElement([
                    'demande',
                    'reponse',
                    'notification',
                    'convocation',
                    'rapport',
                    'facture',
                    'contrat',
                    'correspondance',
                ]),
                'objet' => fake()->randomElement([
                    'Demande de fournitures de bureau',
                    'Convocation à une réunion',
                    'Rapport d\'activité mensuel',
                    'Facture de prestations',
                    'Contrat de maintenance',
                    'Notification de changement',
                    'Demande de congé exceptionnel',
                    'Rapport de mission',
                    'Correspondance administrative',
                ]),
                'description' => fake()->paragraph(),
                'expediteur' => $type === 'entrant' ? fake()->company() : null,
                'destinataire' => $type === 'sortant' ? fake()->company() : null,
                'service_expediteur_id' => $type !== 'entrant' ? $services->random()->id : null,
                'service_destinataire_id' => $type !== 'sortant' ? $services->random()->id : null,
                'date_courrier' => $dateCreation,
                'date_reception' => $type === 'entrant' ? $dateCreation : null,
                'date_envoi' => $type === 'sortant' ? $dateCreation : null,
                'date_limite_reponse' => fake()->boolean(60) ? fake()->dateTimeBetween('now', '+1 month') : null,
                'priorite' => fake()->randomElement(['normale', 'urgente', 'tres_urgente']),
                'status' => fake()->randomElement([
                    'en_attente',
                    'en_cours_traitement',
                    'traite',
                    'archive',
                    'en_attente_reponse',
                ]),
                'user_id' => $users->random()->id,
                'agent_responsable_id' => fake()->boolean(70) ? $users->random()->id : null,
                'repertoire' => fake()->boolean(50) ? fake()->randomElement(['ADMIN', 'TECH', 'COMM', 'FIN']) : null,
                'numero_chrono' => fake()->boolean(60) ? fake()->numerify('####') : null,
                'confidentiel' => fake()->boolean(15),
                'observations' => fake()->boolean(40) ? fake()->sentence() : null,
                'created_at' => $dateCreation,
                'updated_at' => $dateCreation,
            ]);
        }
    }

    private function genererReference($type, $numero): string
    {
        $prefix = match($type) {
            'entrant' => 'CE',
            'sortant' => 'CS',
            'interne' => 'CI',
        };

        return $prefix . '-' . date('Y') . '-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
