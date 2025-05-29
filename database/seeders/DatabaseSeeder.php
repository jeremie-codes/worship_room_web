<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur RH
        $rhUser = User::create([
            'name' => 'Admin RH',
            'email' => 'admin@anadec.com',
            'password' => Hash::make('password'),
            'role' => 'rh',
        ]);

        // Employee::create([
        //     'user_id' => $rhUser->id,
        //     'full_name' => 'Admin RH',
        //     'position' => 'Responsable RH',
        //     'department' => 'Ressources Humaines',
        //     'service' => 'RH',
        //     'grade' => 'Manager',
        //     'hire_date' => now()->subYears(2),
        //     'status' => 'actif',
        // ]);

        // Créer un utilisateur employé
        $employeUser = User::create([
            'name' => 'Jean Dupont',
            'email' => 'employe@anadec.com',
            'password' => Hash::make('password'),
            'role' => 'employe',
        ]);

        // Employee::create([
        //     'user_id' => $employeUser->id,
        //     'full_name' => 'Jean Dupont',
        //     'position' => 'Développeur Web',
        //     'department' => 'IT',
        //     'service' => 'Développement',
        //     'grade' => 'Senior',
        //     'hire_date' => now()->subYear(),
        //     'status' => 'actif',
        // ]);

        // Vous pouvez ajouter d'autres seeders ici
        $this->call([
            // EmployeeSeeder::class,
            // LeaveRequestSeeder::class,
            // AttendanceSeeder::class,
            // SupplyRequestSeeder::class,
            // StockItemSeeder::class,
        ]);
    }
}
