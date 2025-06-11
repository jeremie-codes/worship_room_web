<?php

namespace Database\Seeders;

use App\Models\Stream;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StreamSeeder extends Seeder
{
    public function run()
    {
        $broadcasters = User::where('role', User::ROLE_BROADCASTER)->get();

        $streams = [
            [
                'title' => 'Sunday Morning Worship Service',
                'description' => 'Join us for our weekly worship service with inspiring music and a powerful message.',
                'status' => Stream::STATUS_LIVE,
                'started_at' => now()->subHours(1),
                'viewer_count' => 245,
                'max_viewers' => 312,
                'is_featured' => true,
            ],
            [
                'title' => 'Evening Prayer and Reflection',
                'description' => 'A peaceful time of prayer and meditation to end the day.',
                'status' => Stream::STATUS_LIVE,
                'started_at' => now()->subMinutes(30),
                'viewer_count' => 89,
                'max_viewers' => 156,
            ],
            [
                'title' => 'Youth Bible Study',
                'description' => 'Interactive Bible study session for young adults and teenagers.',
                'status' => Stream::STATUS_SCHEDULED,
                'scheduled_at' => now()->addHours(2),
            ],
            [
                'title' => 'Wednesday Night Service',
                'description' => 'Mid-week encouragement and fellowship.',
                'status' => Stream::STATUS_SCHEDULED,
                'scheduled_at' => now()->addDays(2),
            ],
            [
                'title' => 'Healing and Deliverance Service',
                'description' => 'Special service focused on healing and spiritual breakthrough.',
                'status' => Stream::STATUS_ENDED,
                'started_at' => now()->subDays(1),
                'ended_at' => now()->subDays(1)->addHours(2),
                'max_viewers' => 567,
            ],
            [
                'title' => 'Christmas Special Service',
                'description' => 'Celebrating the birth of our Savior with special music and message.',
                'status' => Stream::STATUS_ENDED,
                'started_at' => now()->subDays(3),
                'ended_at' => now()->subDays(3)->addHours(1.5),
                'max_viewers' => 892,
                'is_featured' => true,
            ],
        ];

        foreach ($streams as $index => $streamData) {
            $broadcaster = $broadcasters[$index % $broadcasters->count()];
            
            Stream::create(array_merge($streamData, [
                'broadcaster_id' => $broadcaster->id,
                'stream_key' => Str::random(32),
            ]));
        }
    }
}