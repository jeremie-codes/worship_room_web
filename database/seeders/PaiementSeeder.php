<?php

namespace Database\Seeders;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('status', 'actif')->get();
        $moisActuel = date('n');
        $anneeActuelle = date('Y');

        $drh = User::whereHas('service', fn($q) => $q->where('code', 'DRH'))->inRandomOrder()->first();
        if (!$drh) {
            $this->command->warn('⚠️ Aucun utilisateur du service DRH trouvé.');
            return;
        }

        for ($mois = $moisActuel - 2; $mois <= $moisActuel; $mois++) {
            $moisAjuste = $mois <= 0 ? $mois + 12 : $mois;
            $anneeAjustee = $mois <= 0 ? $anneeActuelle - 1 : $anneeActuelle;

            foreach ($users as $user) {
                if (Paiement::where('agent_id', $user->id)->where('mois', $moisAjuste)->where('annee', $anneeAjustee)->exists()) {

                    $salaireBase = fake()->numberBetween(200000, 800000);
                    $primes = fake()->numberBetween(0, 100000);
                    $heuresSupp = fake()->numberBetween(0, 50000);
                    $indemnites = fake()->numberBetween(0, 75000);

                    $deductions = fake()->numberBetween(0, 25000);
                    $retenuesFiscales = $salaireBase * 0.1; // 10%
                    $cotisationsSociales = $salaireBase * 0.05; // 5%
                    $avances = fake()->numberBetween(0, 50000);

                    $brut = $salaireBase + $primes + $heuresSupp + $indemnites;
                    $totalDeductions = $deductions + $retenuesFiscales + $cotisationsSociales + $avances;
                    $netAPayer = $brut - $totalDeductions;

                    $status = 'paye';
                    if ($moisAjuste === $moisActuel) {
                        $status = fake()->randomElement(['en_preparation', 'valide', 'paye']);
                    }

                    Paiement::create([
                        'agent_id' => $user->id,
                        'user_id' => User::where('service_id', User::join('services', 'users.service_id', '=', 'services.id')->where('services.code', 'DRH')->first()->service_id)->first()->id,
                        'reference' => 'PAY-' . $anneeAjustee . str_pad($moisAjuste, 2, '0', STR_PAD_LEFT) . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                        'annee' => $anneeAjustee,
                        'mois' => $moisAjuste,
                        'salaire_base' => $salaireBase,
                        'primes' => $primes,
                        'heures_supplementaires' => $heuresSupp,
                        'indemnites' => $indemnites,
                        'deductions' => $deductions,
                        'retenues_fiscales' => $retenuesFiscales,
                        'cotisations_sociales' => $cotisationsSociales,
                        'avances' => $avances,
                        'net_a_payer' => $netAPayer,
                        'status' => $status,
                        'date_paiement' => $status === 'paye' ? fake()->dateTimeThisMonth() : null,
                        'mode_paiement' => $status === 'paye' ? fake()->randomElement(['virement', 'especes', 'cheque']) : null,
                    ]);
                }
            }
        }
    }
}
