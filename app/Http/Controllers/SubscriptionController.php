<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(User $broadcaster)
    {
        $user = Auth::user();

        if ($user->id === $broadcaster->id) {
            return response()->json(['error' => 'You cannot subscribe to yourself'], 400);
        }

        $subscription = Subscription::updateOrCreate([
            'subscriber_id' => $user->id,
            'broadcaster_id' => $broadcaster->id,
        ], [
            'is_active' => true,
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
        ]);

        // Create notification for broadcaster
        Notification::create([
            'user_id' => $broadcaster->id,
            'type' => Notification::TYPE_NEW_SUBSCRIBER,
            'title' => 'New Subscriber',
            'message' => $user->name . ' subscribed to your channel',
            'data' => ['subscriber_id' => $user->id],
        ]);

        return response()->json([
            'subscribed' => true,
            'subscribers_count' => $broadcaster->subscribers()->count(),
        ]);
    }

    public function unsubscribe(User $broadcaster)
    {
        $user = Auth::user();

        Subscription::where('subscriber_id', $user->id)
            ->where('broadcaster_id', $broadcaster->id)
            ->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);

        return response()->json([
            'subscribed' => false,
            'subscribers_count' => $broadcaster->subscribers()->count(),
        ]);
    }

    public function mySubscriptions()
    {
        $subscriptions = Auth::user()->subscriptions()
            ->active()
            ->with('broadcaster')
            ->latest()
            ->paginate(12);

        return view('subscriptions.index', compact('subscriptions'));
    }
}