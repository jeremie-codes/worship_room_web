<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $spectators = User::where('role', User::ROLE_SPECTATOR)->get();
        $broadcasters = User::where('role', User::ROLE_BROADCASTER)->get();

        // Create subscriptions
        foreach ($spectators as $spectator) {
            // Each spectator subscribes to 1-3 broadcasters
            $subscribeTo = $broadcasters->random(rand(1, 3));
            
            foreach ($subscribeTo as $broadcaster) {
                Subscription::create([
                    'subscriber_id' => $spectator->id,
                    'broadcaster_id' => $broadcaster->id,
                    'is_active' => true,
                    'subscribed_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}