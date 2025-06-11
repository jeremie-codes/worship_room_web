<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Video;
use App\Models\Donation;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isBroadcaster()) {
            return $this->broadcasterDashboard();
        } else {
            return $this->spectatorDashboard();
        }
    }

    private function broadcasterDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_donations' => $user->receivedDonations()->completed()->sum('amount'),
            'total_subscribers' => $user->subscribers()->count(),
            'total_streams' => $user->streams()->count(),
            'total_videos' => $user->videos()->count(),
        ];

        $recentStreams = $user->streams()
            ->latest()
            ->take(5)
            ->get();

        $recentDonations = $user->receivedDonations()
            ->with('donor')
            ->completed()
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.broadcaster', compact('stats', 'recentStreams', 'recentDonations'));
    }

    private function spectatorDashboard()
    {
        $liveStreams = Stream::live()
            ->with('broadcaster')
            ->latest('started_at')
            ->take(6)
            ->get();

        $upcomingStreams = Stream::scheduled()
            ->with('broadcaster')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->take(4)
            ->get();

        $featuredVideos = Video::published()
            ->featured()
            ->with('broadcaster')
            ->latest('published_at')
            ->take(6)
            ->get();

        $recentVideos = Video::published()
            ->with('broadcaster')
            ->latest('published_at')
            ->take(8)
            ->get();

        $subscribedBroadcasters = Auth::user()
            ->subscriptions()
            ->active()
            ->with('broadcaster')
            ->latest()
            ->take(5)
            ->get()
            ->pluck('broadcaster');

        return view('dashboard.spectator', compact(
            'liveStreams',
            'upcomingStreams',
            'featuredVideos',
            'recentVideos',
            'subscribedBroadcasters'
        ));
    }
}