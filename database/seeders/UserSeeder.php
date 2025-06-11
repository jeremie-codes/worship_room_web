<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin broadcaster
        User::create([
            'name' => 'Pastor John Smith',
            'email' => 'pastor@worshiproom.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_BROADCASTER,
            'bio' => 'Senior Pastor at Grace Community Church. Spreading the word of God through digital ministry.',
            'is_active' => true,
        ]);

        // Create sample broadcasters
        $broadcasters = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@worshiproom.com',
                'bio' => 'Youth Pastor passionate about connecting with the next generation.',
                'role' => User::ROLE_BROADCASTER,
            ],
            [
                'name' => 'Michael Davis',
                'email' => 'michael@worshiproom.com',
                'bio' => 'Worship leader and musician sharing inspirational messages.',
                'role' => User::ROLE_BROADCASTER,
            ],
            [
                'name' => 'Rachel Thompson',
                'email' => 'rachel@worshiproom.com',
                'bio' => 'Bible study teacher and spiritual counselor.',
                'role' => User::ROLE_BROADCASTER,
            ],
        ];

        foreach ($broadcasters as $broadcaster) {
            User::create(array_merge($broadcaster, [
                'password' => Hash::make('password'),
                'is_active' => true,
            ]));
        }

        // Create sample spectators
        $spectators = [
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'role' => User::ROLE_SPECTATOR,
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emily@example.com',
                'role' => User::ROLE_SPECTATOR,
            ],
            [
                'name' => 'James Miller',
                'email' => 'james@example.com',
                'role' => User::ROLE_SPECTATOR,
            ],
            [
                'name' => 'Lisa Garcia',
                'email' => 'lisa@example.com',
                'role' => User::ROLE_SPECTATOR,
            ],
            [
                'name' => 'Robert Martinez',
                'email' => 'robert@example.com',
                'role' => User::ROLE_SPECTATOR,
            ],
        ];

        foreach ($spectators as $spectator) {
            User::create(array_merge($spectator, [
                'password' => Hash::make('password'),
                'is_active' => true,
            ]));
        }
    }
}