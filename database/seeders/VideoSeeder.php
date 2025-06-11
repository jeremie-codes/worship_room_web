<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $broadcasters = User::where('role', User::ROLE_BROADCASTER)->get();

        $videos = [
            [
                'title' => 'The Power of Faith in Difficult Times',
                'description' => 'A powerful message about maintaining faith during life\'s challenges.',
                'video_url' => 'https://example.com/video1.mp4',
                'duration' => 2340, // 39 minutes
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 1250,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Walking in God\'s Purpose',
                'description' => 'Discovering and fulfilling your divine calling.',
                'video_url' => 'https://example.com/video2.mp4',
                'duration' => 1890, // 31.5 minutes
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 890,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Worship Through Music',
                'description' => 'An inspiring worship session with contemporary Christian music.',
                'video_url' => 'https://example.com/video3.mp4',
                'duration' => 3600, // 1 hour
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 2100,
                'published_at' => now()->subWeek(),
            ],
            [
                'title' => 'Bible Study: Romans Chapter 8',
                'description' => 'Deep dive into Paul\'s letter to the Romans.',
                'video_url' => 'https://example.com/video4.mp4',
                'duration' => 2700, // 45 minutes
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 567,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Prayer and Fasting Guidelines',
                'description' => 'Biblical principles for effective prayer and fasting.',
                'video_url' => 'https://example.com/video5.mp4',
                'duration' => 1800, // 30 minutes
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 734,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Youth Conference Highlights',
                'description' => 'Best moments from our annual youth conference.',
                'video_url' => 'https://example.com/video6.mp4',
                'duration' => 4200, // 1 hour 10 minutes
                'status' => Video::STATUS_PUBLISHED,
                'view_count' => 1456,
                'is_featured' => true,
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($videos as $index => $videoData) {
            $broadcaster = $broadcasters[$index % $broadcasters->count()];
            
            Video::create(array_merge($videoData, [
                'broadcaster_id' => $broadcaster->id,
            ]));
        }
    }
}