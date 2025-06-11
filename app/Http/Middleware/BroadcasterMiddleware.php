<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcasterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isBroadcaster()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Broadcaster role required.');
        }

        return $next($request);
    }
}