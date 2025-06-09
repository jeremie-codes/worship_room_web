<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        // Utilisateur administrateur
        User::create([
            'matricule' => 'ADM001',
            'name' => 'Administrateur Système',
            'email' => 'admin@anadec.com',
            'password' => Hash::make('password'),
            'date_naissance' => '1980-01-15',
            'lieu_naissance' => 'Abidjan',
            'sexe' => 'M',
            'adresse' => 'Cocody, Abidjan',
            'telephone' => '+225 07 00 00 00',
            'date_engagement' => '2020-01-01',
            'status' => 'actif',
            'service_id' => $services->where('code', 'DG')->first()->id,
            'observations' => 'Administrateur principal du système',
        ]);

        // Directeur Général
        User::create([
            'matricule' => 'DG001',
            'name' => 'KOUAME Jean-Baptiste',
            'email' => 'dg@anadec.com',
            'password' => Hash::make('password'),
            'date_naissance' => '1975-03-20',
            'lieu_naissance' => 'Yamoussoukro',
            'sexe' => 'M',
            'adresse' => 'Plateau, Abidjan',
            'telephone' => '+225 07 11 11 11',
            'date_engagement' => '2018-01-15',
            'status' => 'actif',
            'service_id' => $services->where('code', 'DG')->first()->id,
        ]);

        // Directeur RH
        User::create([
            'matricule' => 'DRH001',
            'name' => 'TRAORE Aminata',
            'email' => 'drh@anadec.com',
            'password' => Hash::make('password'),
            'date_naissance' => '1982-07-10',
            'lieu_naissance' => 'Bouaké',
            'sexe' => 'F',
            'adresse' => 'Marcory, Abidjan',
            'telephone' => '+225 07 22 22 22',
            'date_engagement' => '2019-03-01',
            'status' => 'actif',
            'service_id' => $services->where('code', 'DRH')->first()->id,
        ]);

        // Agents RH
        $nomsRH = [
            ['KONE Fatou', 'F', 'kone.fatou@anadec.com'],
            ['DIALLO Moussa', 'M', 'diallo.moussa@anadec.com'],
            ['BAMBA Mariam', 'F', 'bamba.mariam@anadec.com'],
        ];

        foreach ($nomsRH as $index => $agent) {
            User::create([
                'matricule' => 'RH' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'name' => $agent[0],
                'email' => $agent[2],
                'password' => Hash::make('password'),
                'date_naissance' => fake()->dateTimeBetween('1980-01-01', '1995-12-31'),
                'lieu_naissance' => fake()->randomElement(['Abidjan', 'Bouaké', 'Yamoussoukro', 'San Pedro', 'Korhogo']),
                'sexe' => $agent[1],
                'adresse' => fake()->address(),
                'telephone' => '+225 07 ' . fake()->numerify('## ## ##'),
                'date_engagement' => fake()->dateTimeBetween('2020-01-01', '2023-12-31'),
                'status' => 'actif',
                'service_id' => $services->where('code', 'DRH')->first()->id,
            ]);
        }

        // Agents autres services
        $autresServices = $services->whereNotIn('code', ['DG', 'DRH']);

        foreach ($autresServices as $service) {
            $nombreAgents = fake()->numberBetween(3, 8);

            for ($i = 1; $i <= $nombreAgents; $i++) {
                $sexe = fake()->randomElement(['M', 'F']);
                $prenom = $sexe === 'M' ? fake()->firstNameMale() : fake()->firstNameFemale();
                $nom = fake()->lastName();

                User::create([
                    'matricule' => $service->code . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'name' => strtoupper($nom) . ' ' . $prenom,
                    'email' => strtolower($prenom . '.' . $nom . '@anadec.com'),
                    'password' => Hash::make('password'),
                    'date_naissance' => fake()->dateTimeBetween('1980-01-01', '1995-12-31'),
                    'lieu_naissance' => fake()->randomElement(['Abidjan', 'Bouaké', 'Yamoussoukro', 'San Pedro', 'Korhogo', 'Daloa', 'Man', 'Gagnoa']),
                    'sexe' => $sexe,
                    'adresse' => fake()->address(),
                    'telephone' => '+225 0' . fake()->randomElement([1, 5, 7]) . ' ' . fake()->numerify('## ## ##'),
                    'date_engagement' => fake()->dateTimeBetween('2018-01-01', '2024-01-01'),
                    'status' => fake()->randomElement(['actif', 'actif', 'actif', 'actif', 'actif', 'retraite', 'malade']),
                    'service_id' => $service->id,
                ]);
            }
        }
    }
}
