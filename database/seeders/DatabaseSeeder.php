<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            StreamSeeder::class,
            VideoSeeder::class,
            CommentSeeder::class,
            DonationSeeder::class,
            SubscriptionSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}