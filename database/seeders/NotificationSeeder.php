<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        $notifications = [
            [
                'type' => Notification::TYPE_STREAM_STARTED,
                'title' => 'Live Stream Started',
                'message' => 'Pastor John Smith is now live with "Sunday Morning Worship Service"',
            ],
            [
                'type' => Notification::TYPE_NEW_SUBSCRIBER,
                'title' => 'New Subscriber',
                'message' => 'David Wilson subscribed to your channel',
            ],
            [
                'type' => Notification::TYPE_DONATION_RECEIVED,
                'title' => 'Donation Received',
                'message' => 'Emily Brown donated $25.00 to your ministry',
            ],
            [
                'type' => Notification::TYPE_VIDEO_PUBLISHED,
                'title' => 'New Video Published',
                'message' => 'Sarah Johnson published "Youth Bible Study Session"',
            ],
        ];

        foreach ($users as $user) {
            // Create 3-7 notifications per user
            $notificationCount = rand(3, 7);
            
            for ($i = 0; $i < $notificationCount; $i++) {
                $notification = $notifications[array_rand($notifications)];
                
                Notification::create([
                    'user_id' => $user->id,
                    'type' => $notification['type'],
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'data' => [],
                    'is_read' => rand(0, 2) === 0, // 33% chance of being read
                    'created_at' => now()->subDays(rand(1, 14)),
                ]);
            }
        }
    }
}