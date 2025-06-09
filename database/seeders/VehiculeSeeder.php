<?php

namespace Database\Seeders;

use App\Models\Vehicule;
use Illuminate\Database\Seeder;

class VehiculeSeeder extends Seeder
{
    public function run(): void
    {
        $vehicules = [
            [
                'immatriculation' => '1234 AB 01',
                'marque' => 'Toyota',
                'modele' => 'Hilux',
                'annee' => 2020,
                'etat' => 'bon_etat',
                'observations' => 'Véhicule de service en excellent état',
            ],
            [
                'immatriculation' => '5678 CD 01',
                'marque' => 'Nissan',
                'modele' => 'Patrol',
                'annee' => 2019,
                'etat' => 'bon_etat',
                'observations' => 'Véhicule tout-terrain pour missions',
            ],
            [
                'immatriculation' => '9012 EF 01',
                'marque' => 'Peugeot',
                'modele' => '508',
                'annee' => 2021,
                'etat' => 'bon_etat',
                'observations' => 'Véhicule de direction',
            ],
            [
                'immatriculation' => '3456 GH 01',
                'marque' => 'Renault',
                'modele' => 'Duster',
                'annee' => 2018,
                'etat' => 'en_entretien',
                'observations' => 'En maintenance préventive',
            ],
            [
                'immatriculation' => '7890 IJ 01',
                'marque' => 'Ford',
                'modele' => 'Transit',
                'annee' => 2017,
                'etat' => 'en_panne',
                'observations' => 'Problème moteur à réparer',
            ],
            [
                'immatriculation' => '2468 KL 01',
                'marque' => 'Hyundai',
                'modele' => 'Tucson',
                'annee' => 2022,
                'etat' => 'bon_etat',
                'observations' => 'Véhicule récent, très bon état',
            ],
        ];

        foreach ($vehicules as $vehicule) {
            Vehicule::create($vehicule);
        }
    }
}
