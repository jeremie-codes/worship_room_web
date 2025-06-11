<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
use App\Models\Stream;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    public function run()
    {
        $spectators = User::where('role', User::ROLE_SPECTATOR)->get();
        $broadcasters = User::where('role', User::ROLE_BROADCASTER)->get();
        $streams = Stream::all();

        $donationMessages = [
            'Thank you for this powerful message!',
            'God bless your ministry.',
            'Keep up the great work!',
            'Praying for your continued success.',
            'This message touched my heart.',
            'Supporting your ministry with love.',
            'May God multiply this seed.',
            'Thank you for serving God faithfully.',
            'Blessed to support this ministry.',
            'Keep preaching the truth!',
        ];

        // Create donations
        for ($i = 0; $i < 50; $i++) {
            $donor = $spectators->random();
            $broadcaster = $broadcasters->random();
            $stream = rand(0, 1) ? $streams->random() : null;
            
            Donation::create([
                'donor_id' => $donor->id,
                'broadcaster_id' => $broadcaster->id,
                'stream_id' => $stream?->id,
                'amount' => rand(5, 500),
                'currency' => 'USD',
                'payment_method' => rand(0, 1) ? Donation::PAYMENT_METHOD_CARD : Donation::PAYMENT_METHOD_MOBILE_MONEY,
                'payment_reference' => 'PAY_' . strtoupper(uniqid()),
                'status' => Donation::STATUS_COMPLETED,
                'message' => rand(0, 1) ? $donationMessages[array_rand($donationMessages)] : null,
                'is_anonymous' => rand(0, 4) === 0, // 20% chance of anonymous
                'processed_at' => now()->subDays(rand(1, 30)),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}