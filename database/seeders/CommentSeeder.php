<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Stream;
use App\Models\Video;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', User::ROLE_SPECTATOR)->get();
        $streams = Stream::all();
        $videos = Video::all();

        $streamComments = [
            'Amen! This message is exactly what I needed to hear today.',
            'Thank you Pastor for this powerful word!',
            'Praying for everyone watching this stream.',
            'God bless you all! 🙏',
            'This worship music is so beautiful.',
            'Feeling the presence of God right now.',
            'Thank you for this live service!',
            'Can you pray for my family?',
            'Hallelujah! Praise the Lord!',
            'This is such an encouraging message.',
        ];

        $videoComments = [
            'I\'ve watched this video multiple times. So inspiring!',
            'Thank you for sharing God\'s word.',
            'This helped me through a difficult time.',
            'Excellent teaching! Very clear and practical.',
            'Sharing this with my small group.',
            'God bless your ministry!',
            'This video changed my perspective.',
            'Thank you for making this available online.',
            'Powerful message! Amen!',
            'I needed to hear this today.',
        ];

        // Add comments to streams
        foreach ($streams as $stream) {
            $commentCount = rand(3, 8);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'stream_id' => $stream->id,
                    'content' => $streamComments[array_rand($streamComments)],
                    'created_at' => now()->subMinutes(rand(1, 120)),
                ]);
            }
        }

        // Add comments to videos
        foreach ($videos as $video) {
            $commentCount = rand(5, 15);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'video_id' => $video->id,
                    'content' => $videoComments[array_rand($videoComments)],
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}