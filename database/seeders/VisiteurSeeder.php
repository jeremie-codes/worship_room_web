<?php

namespace Database\Seeders;

use App\Models\Visiteur;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisiteurSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();
        $users = User::where('status', 'actif')->get();

        // Visiteurs des 7 derniers jours
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $nombreVisiteurs = fake()->numberBetween(2, 8);

            for ($j = 0; $j < $nombreVisiteurs; $j++) {
                $heureArrivee = $date->copy()->setTime(
                    fake()->numberBetween(8, 17),
                    fake()->numberBetween(0, 59)
                );

                $estParti = fake()->boolean(70);
                $heureDepart = null;
                $status = 'en_visite';

                if ($estParti || $i > 0) { // Les visiteurs des jours précédents sont partis
                    $heureDepart = $heureArrivee->copy()->addHours(fake()->numberBetween(1, 6));
                    $status = 'parti';
                }

                $type = fake()->randomElement(['visiteur', 'entrepreneur']);
                $vehicule = fake()->boolean(30);

                $accompagnants = [];
                if (fake()->boolean(20)) {
                    $nombreAccompagnants = fake()->numberBetween(1, 3);
                    for ($k = 0; $k < $nombreAccompagnants; $k++) {
                        $accompagnants[] = [
                            'nom' => fake()->lastName(),
                            'prenom' => fake()->firstName(),
                            'piece_identite' => fake()->randomElement(['CNI', 'Passeport', 'Permis']),
                        ];
                    }
                }

                Visiteur::create([
                    'nom' => fake()->lastName(),
                    'prenom' => fake()->firstName(),
                    'type' => $type,
                    'entreprise' => $type === 'entrepreneur' ? fake()->company() : null,
                    'telephone' => '+225 0' . fake()->randomElement([1, 5, 7]) . ' ' . fake()->numerify('## ## ##'),
                    'email' => fake()->boolean(60) ? fake()->email() : null,
                    'piece_identite' => fake()->randomElement(['cni', 'passeport', 'permis']),
                    'numero_piece' => fake()->numerify('##########'),
                    'motif' => fake()->randomElement([
                        'Réunion de travail',
                        'Livraison de matériel',
                        'Maintenance équipement',
                        'Formation du personnel',
                        'Audit des installations',
                        'Présentation de services',
                        'Négociation contrat',
                        'Visite de courtoisie',
                    ]),
                    'service_id' => $services->random()->id,
                    'destination' => fake()->randomElement([
                        'Bureau du Directeur',
                        'Salle de réunion',
                        'Service technique',
                        'Accueil',
                        'Comptabilité',
                    ]),
                    'heure_arrivee' => $heureArrivee,
                    'heure_depart' => $heureDepart,
                    'observations' => fake()->boolean(30) ? fake()->sentence() : null,
                    'status' => $status,
                    'user_id' => $users->random()->id,
                    'badge_numero' => 'V' . $date->format('Ymd') . sprintf('%03d', $j + 1),
                    'vehicule' => $vehicule,
                    'immatriculation_vehicule' => $vehicule ? fake()->numerify('#### AB ##') : null,
                    'accompagnants' => $accompagnants,
                    'created_at' => $heureArrivee,
                    'updated_at' => $heureDepart ?? $heureArrivee,
                ]);
            }
        }
    }
}
