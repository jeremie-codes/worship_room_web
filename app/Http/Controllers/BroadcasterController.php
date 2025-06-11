<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Video;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcasterController extends Controller
{
    public function streams()
    {
        $streams = Auth::user()->streams()
            ->latest()
            ->paginate(10);

        return view('broadcaster.streams', compact('streams'));
    }

    public function videos()
    {
        $videos = Auth::user()->videos()
            ->latest()
            ->paginate(10);

        return view('broadcaster.videos', compact('videos'));
    }

    public function donations()
    {
        $donations = Auth::user()->receivedDonations()
            ->with('donor')
            ->latest()
            ->paginate(15);

        $totalDonations = Auth::user()->receivedDonations()->completed()->sum('amount');

        return view('broadcaster.donations', compact('donations', 'totalDonations'));
    }

    public function profile()
    {
        return view('broadcaster.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'website_url' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function deactivateAccount()
    {
        $user = Auth::user();
        $user->update([
            'is_active' => false,
            'account_deactivated_at' => now(),
        ]);

        Auth::logout();

        return redirect('/')->with('success', 'Your account has been deactivated.');
    }
}