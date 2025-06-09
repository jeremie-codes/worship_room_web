<?php

namespace Database\Seeders;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'actif')->get();
        $today = Carbon::today();

        // Générer les présences pour les 7 derniers jours
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);

            foreach ($users as $user) {
                // 85% de chance d'être présent
                $isPresent = fake()->boolean(85);

                if ($isPresent) {
                    $heureArrivee = $date->copy()->setTime(
                        fake()->numberBetween(7, 9),
                        fake()->numberBetween(0, 59)
                    );

                    $status = 'present';
                    if ($heureArrivee->hour >= 8 && $heureArrivee->minute > 30) {
                        $status = 'retard';
                    }

                    Presence::create([
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => $status,
                        'heure_arrivee' => $heureArrivee,
                        'justification' => $status === 'retard' ? fake()->randomElement([
                            'Embouteillage',
                            'Problème de transport',
                            'Urgence familiale',
                            null
                        ]) : null,
                    ]);
                } else {
                    // 10% de chance d'absence
                    $status = fake()->randomElement(['absent', 'justifie', 'autorise']);

                    Presence::create([
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => $status,
                        'heure_arrivee' => null,
                        'justification' => $status !== 'absent' ? fake()->randomElement([
                            'Congé maladie',
                            'Formation',
                            'Mission officielle',
                            'Congé autorisé',
                        ]) : null,
                    ]);
                }
            }
        }
    }
}
