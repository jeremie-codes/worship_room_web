<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'nom' => 'Administrateur',
            'description' => 'Accès complet au système',
            'permissions' => [
                'employes',
                'conges',
                'presences',
                'utilisateurs',
                'roles',
                'rapports',
                'logistique',
            ],
        ]);

        Role::create([
            'nom' => 'Responsable RH',
            'description' => 'Gestion des ressources humaines',
            'permissions' => [
                'employes',
                'conges',
                'presences',
                'rapports',
            ],
        ]);

        Role::create([
            'nom' => 'Employé',
            'description' => 'Accès limité au système',
            'permissions' => [
                'conges.demande',
                'presences.consultation',
            ],
        ]);
    }
}