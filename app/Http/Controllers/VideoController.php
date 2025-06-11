<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Comment;
use App\Models\Like;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        $featuredVideos = Video::published()
            ->featured()
            ->with('broadcaster')
            ->latest('published_at')
            ->take(6)
            ->get();

        $recentVideos = Video::published()
            ->with('broadcaster')
            ->latest('published_at')
            ->paginate(12);

        return view('videos.index', compact('featuredVideos', 'recentVideos'));
    }

    public function show(Video $video)
    {
        $video->load('broadcaster', 'comments.user', 'likes');
        $video->increment('view_count');

        if (Auth::check()) {
            WatchHistory::updateOrCreate([
                'user_id' => Auth::id(),
                'video_id' => $video->id,
            ], [
                'last_position' => 0,
            ]);
        }

        $relatedVideos = Video::published()
            ->where('broadcaster_id', $video->broadcaster_id)
            ->where('id', '!=', $video->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $userHasLiked = Auth::check() ? 
            $video->likes()->where('user_id', Auth::id())->exists() : false;

        $userIsSubscribed = Auth::check() ? 
            Auth::user()->subscriptions()
                ->where('broadcaster_id', $video->broadcaster_id)
                ->where('is_active', true)
                ->exists() : false;

        return view('videos.show', compact(
            'video', 
            'relatedVideos', 
            'userHasLiked', 
            'userIsSubscribed'
        ));
    }

    public function like(Video $video)
    {
        $user = Auth::user();
        
        $existing = Like::where('user_id', $user->id)
            ->where('video_id', $video->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'video_id' => $video->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $video->likes()->count(),
        ]);
    }

    public function comment(Request $request, Video $video)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'content' => $validated['content'],
        ]);

        $comment->load('user');

        return response()->json([
            'comment' => $comment,
            'html' => view('partials.comment', compact('comment'))->render(),
        ]);
    }
}