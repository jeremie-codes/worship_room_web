<?php

namespace Database\Seeders;

use App\Models\Chauffeur;
use Illuminate\Database\Seeder;

class ChauffeurSeeder extends Seeder
{
    public function run(): void
    {
        $chauffeurs = [
            [
                'matricule' => 'CH001',
                'nom' => 'OUATTARA',
                'prenom' => 'Ibrahim',
                'telephone' => '+225 07 11 22 33',
                'numero_permis' => 'CI123456789',
                'date_expiration_permis' => '2025-12-31',
                'status' => 'disponible',
                'observations' => 'Chauffeur expérimenté, 15 ans d\'expérience',
            ],
            [
                'matricule' => 'CH002',
                'nom' => 'KOFFI',
                'prenom' => 'Adjoua',
                'telephone' => '+225 05 44 55 66',
                'numero_permis' => 'CI987654321',
                'date_expiration_permis' => '2026-06-15',
                'status' => 'disponible',
                'observations' => 'Spécialisée dans les véhicules légers',
            ],
            [
                'matricule' => 'CH003',
                'nom' => 'DIABATE',
                'prenom' => 'Seydou',
                'telephone' => '+225 07 77 88 99',
                'numero_permis' => 'CI456789123',
                'date_expiration_permis' => '2025-03-20',
                'status' => 'en_mission',
                'observations' => 'Actuellement en mission à l\'intérieur du pays',
            ],
            [
                'matricule' => 'CH004',
                'nom' => 'COULIBALY',
                'prenom' => 'Mamadou',
                'telephone' => '+225 01 23 45 67',
                'numero_permis' => 'CI789123456',
                'date_expiration_permis' => '2024-11-30',
                'status' => 'disponible',
                'observations' => 'Permis à renouveler bientôt',
            ],
            [
                'matricule' => 'CH005',
                'nom' => 'YAO',
                'prenom' => 'Akissi',
                'telephone' => '+225 05 98 76 54',
                'numero_permis' => 'CI321654987',
                'date_expiration_permis' => '2027-01-15',
                'status' => 'indisponible',
                'observations' => 'En congé maladie',
            ],
        ];

        foreach ($chauffeurs as $chauffeur) {
            Chauffeur::create($chauffeur);
        }
    }
}
