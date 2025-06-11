<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StreamController extends Controller
{
    public function index()
    {
        $liveStreams = Stream::live()
            ->with('broadcaster')
            ->orderByDesc('viewer_count')
            ->paginate(12);

        $upcomingStreams = Stream::scheduled()
            ->with('broadcaster')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->paginate(8);

        return view('streams.index', compact('liveStreams', 'upcomingStreams'));
    }

    public function show(Stream $stream)
    {
        $stream->load('broadcaster', 'comments.user', 'likes');
        
        $relatedStreams = Stream::where('broadcaster_id', $stream->broadcaster_id)
            ->where('id', '!=', $stream->id)
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->take(4)
            ->get();

        $userHasLiked = Auth::check() ? 
            $stream->likes()->where('user_id', Auth::id())->exists() : false;

        $userIsSubscribed = Auth::check() ? 
            Auth::user()->subscriptions()
                ->where('broadcaster_id', $stream->broadcaster_id)
                ->where('is_active', true)
                ->exists() : false;

        return view('streams.show', compact(
            'stream', 
            'relatedStreams', 
            'userHasLiked', 
            'userIsSubscribed'
        ));
    }

    public function create()
    {
        return view('streams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'scheduled_at' => 'nullable|date|after:now',
            'is_immediate' => 'boolean',
        ]);

        $stream = new Stream($validated);
        $stream->broadcaster_id = Auth::id();
        $stream->stream_key = Str::random(32);
        
        if ($request->boolean('is_immediate')) {
            $stream->status = Stream::STATUS_LIVE;
            $stream->started_at = now();
        } else {
            $stream->status = Stream::STATUS_SCHEDULED;
        }

        if ($request->hasFile('cover_image')) {
            $stream->cover_image = $request->file('cover_image')->store('stream-covers', 'public');
        }

        $stream->save();

        return redirect()->route('broadcaster.streams')->with('success', 'Stream created successfully!');
    }

    public function like(Stream $stream)
    {
        $user = Auth::user();
        
        $existing = Like::where('user_id', $user->id)
            ->where('stream_id', $stream->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'stream_id' => $stream->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $stream->likes()->count(),
        ]);
    }

    public function comment(Request $request, Stream $stream)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'stream_id' => $stream->id,
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        return response()->json([
            'comment' => $comment,
            'html' => view('partials.comment', compact('comment'))->render(),
        ]);
    }
}