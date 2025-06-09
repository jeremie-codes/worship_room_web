<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'nom' => 'Direction Générale',
                'code' => 'DG',
                'description' => 'Direction Générale de l\'ANADEC',
            ],
            [
                'nom' => 'Direction des Ressources Humaines',
                'code' => 'DRH',
                'description' => 'Gestion des ressources humaines',
            ],
            [
                'nom' => 'Direction Financière et Comptable',
                'code' => 'DFC',
                'description' => 'Gestion financière et comptable',
            ],
            [
                'nom' => 'Direction Technique',
                'code' => 'DT',
                'description' => 'Direction technique et opérationnelle',
            ],
            [
                'nom' => 'Direction Commerciale',
                'code' => 'DC',
                'description' => 'Direction commerciale et marketing',
            ],
            [
                'nom' => 'Service Informatique',
                'code' => 'SI',
                'description' => 'Service informatique et systèmes',
            ],
            [
                'nom' => 'Service Logistique',
                'code' => 'SL',
                'description' => 'Service logistique et approvisionnement',
            ],
            [
                'nom' => 'Service Juridique',
                'code' => 'SJ',
                'description' => 'Service juridique et contentieux',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
