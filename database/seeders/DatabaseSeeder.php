<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            UserSeeder::class,
            ArticleSeeder::class,
            VehiculeSeeder::class,
            ChauffeurSeeder::class,
            PresenceSeeder::class,
            CongeSeeder::class,
            MissionSeeder::class,
            CotationSeeder::class,
            DemandeFournitureSeeder::class,
            PaiementSeeder::class,
            CourrierSeeder::class,
            VisiteurSeeder::class,
        ]);
    }
}
