<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $liveStreams = Stream::live()
            ->with('broadcaster')
            ->orderByDesc('viewer_count')
            ->take(6)
            ->get();

        $featuredVideos = Video::published()
            ->featured()
            ->with('broadcaster')
            ->latest('published_at')
            ->take(4)
            ->get();

        $recentVideos = Video::published()
            ->with('broadcaster')
            ->latest('published_at')
            ->take(8)
            ->get();

        return view('welcome', compact('liveStreams', 'featuredVideos', 'recentVideos'));
    }
}