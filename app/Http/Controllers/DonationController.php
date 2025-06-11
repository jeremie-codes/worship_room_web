<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use App\Models\Stream;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function create(Request $request)
    {
        $broadcasterId = $request->get('broadcaster_id');
        $streamId = $request->get('stream_id');
        
        $broadcaster = User::findOrFail($broadcasterId);
        $stream = $streamId ? Stream::find($streamId) : null;

        return view('donations.create', compact('broadcaster', 'stream'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'broadcaster_id' => 'required|exists:users,id',
            'stream_id' => 'nullable|exists:streams,id',
            'amount' => 'required|numeric|min:1|max:10000',
            'payment_method' => 'required|in:card,mobile_money',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ]);

        $donation = Donation::create([
            'donor_id' => Auth::id(),
            'broadcaster_id' => $validated['broadcaster_id'],
            'stream_id' => $validated['stream_id'] ?? null,
            'amount' => $validated['amount'],
            'currency' => 'USD', // Default currency
            'payment_method' => $validated['payment_method'],
            'status' => Donation::STATUS_PENDING,
            'message' => $validated['message'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ]);

        // Simulate payment processing
        // In real app, integrate with payment gateway
        $donation->update([
            'status' => Donation::STATUS_COMPLETED,
            'payment_reference' => 'PAY_' . strtoupper(uniqid()),
            'processed_at' => now(),
        ]);

        // Create notification for broadcaster
        $donorName = $donation->is_anonymous ? 'Anonymous' : Auth::user()->name;
        Notification::create([
            'user_id' => $donation->broadcaster_id,
            'type' => Notification::TYPE_DONATION_RECEIVED,
            'title' => 'New Donation Received',
            'message' => $donorName . ' donated $' . number_format($donation->amount, 2),
            'data' => ['donation_id' => $donation->id],
        ]);

        return redirect()->back()->with('success', 'Thank you for your donation!');
    }

    public function history()
    {
        $donations = Auth::user()->donations()
            ->with('broadcaster')
            ->latest()
            ->paginate(15);

        return view('donations.history', compact('donations'));
    }
}